<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\InventoryTransaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with(['brand', 'inventory'])->orderBy('product_name')->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json([]);
        }

        $products = Product::with(['brand', 'inventory'])
            ->where('product_name', 'LIKE', '%'.$query.'%')
            ->orderBy('product_name', 'asc')
            ->limit(10)
            // ->get();
            ->get(['id as value', 'product_name as label']);

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::orderBy('brand_name')->get();

        return Inertia::render('Products/Form', [
            'product' => new Product,
            'brands' => $brands,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            $productAttribute = [
                'nama' => $product->product_name,
                'merk' => $product->brand->brand_name,
                'kategori' => $product->tag,
                'spesifikasi' => $product->description,
            ];
            InventoryTransaction::create([
                'product_id' => $product->id,
                'quantity_change' => 0,
                'transaction_type' => 'NEW_PRODUCT',
                'reference_id' => $product->id,
                'transaction_date' => $product->created_at,
                'user_id' => auth()->id(),
                'note' => 'Produk baru ditambahkan. ['.
                implode('; ', array_map(fn ($k, $v) => "$k: $v", array_keys($productAttribute), $productAttribute))
                .']',
            ]);

            return redirect()->route('products.index')
                ->with('success', 'Product created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response
    {
        $transactions = \App\Models\InventoryTransaction::with(['product', 'purchaseOrder', 'user'])
            ->where('product_id', $product->id)
            // ->groupBy('reference_id')
            ->orderBy('inventory_transactions.created_at', 'desc')
            ->get();

        return Inertia::render('Products/Show', [
            'product' => $product,
            'transactions' => $transactions,
        ]);
    }

    public function get(Product $product)
    {
        return response()->json($product->load('brand'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $brands = Brand::orderBy('brand_name')->get();

        return Inertia::render('Products/Form', [
            'product' => $product,
            'brands' => $brands,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        $oldProductAttribute = [
            'nama' => $product->product_name,
            'merk' => $product->brand->brand_name,
            'kategori' => $product->tag,
            'spesifikasi' => $product->description,
        ];
        $product->update($request->validated());
        $updatedProduct = Product::find($product->id);
        $updatedProductAttribute = [
            'nama' => $updatedProduct->product_name,
            'merk' => $updatedProduct->brand->brand_name,
            'kategori' => $updatedProduct->tag,
            'spesifikasi' => $updatedProduct->description,
        ];
        InventoryTransaction::create([
            'product_id' => $product->id,
            'quantity_change' => 0,
            'transaction_type' => 'NEW_PRODUCT',
            'reference_id' => $product->id,
            'transaction_date' => $product->created_at,
            'user_id' => auth()->id(),
            'note' => 'Produk diedit dari ['.
            implode('; ', array_map(fn ($k, $v) => "$k: $v", array_keys($oldProductAttribute), $oldProductAttribute))
            .'] menjadi ['.
            implode('; ', array_map(fn ($k, $v) => "$k: $v", array_keys($updatedProductAttribute), $updatedProductAttribute))
            .']',
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Data deleted successfully.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExport;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Brand;
use App\Models\InventoryTransaction;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $stockStatus = $request->input('stock_status', 'all');

        $inventorySummary = Product::leftJoin('inventories', 'products.id', '=', 'inventories.product_id')
            ->selectRaw('
                COUNT(1) AS all_count,
                SUM(CASE WHEN COALESCE(inventories.quantity, 0) > products.minimum_quantity THEN 1 ELSE 0 END) AS available_count,
                SUM(CASE WHEN COALESCE(inventories.quantity, 0) < products.minimum_quantity AND COALESCE(inventories.quantity, 0) > 0 THEN 1 ELSE 0 END) AS less_count,
                SUM(CASE WHEN COALESCE(inventories.quantity, 0) <= 0 THEN 1 ELSE 0 END) AS empty_count
            ')
            ->first();

        $products = Product::with(['brand', 'tag', 'inventory']);
        switch ($stockStatus) {
            case 'available':
                $products->whereHas('inventory', function ($query) {
                    $query->whereRaw('COALESCE(inventories.quantity, 0) > products.minimum_quantity');
                });
                break;

            case 'less':
                $products->whereHas('inventory', function ($query) {
                    $query->whereRaw('COALESCE(inventories.quantity, 0) < products.minimum_quantity')
                        ->whereRaw('COALESCE(inventories.quantity, 0) > 0');
                });
                break;

            case 'empty':
                $products->where(function ($query) {
                    $query->whereDoesntHave('inventory') // Products without inventory
                        ->orWhereHas('inventory', function ($subQuery) {
                            $subQuery->whereRaw('COALESCE(inventories.quantity, 0) = 0');
                        });
                });
                break;
        }
        $products = $products->orderBy('product_name')->get();

        return Inertia::render('Products/Index', [
            'products' => $products,
            'inventorySummary' => $inventorySummary,
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
        $tags = Tag::orderBy('tag_name')->get();

        return Inertia::render('Products/Form', [
            'product' => new Product,
            'brands' => $brands,
            'tags' => $tags,
            'units' => Unit::orderBy('unit_name')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = Product::create($request->validated());
            $unit_conversions = $request->validated()['unit_conversions'];
            $product->unitConversions()->delete();
            foreach ($unit_conversions as $unit_conversion) {
                $product->unitConversions()->create($unit_conversion);
            }
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
        $tags = Tag::orderBy('tag_name')->get();

        return Inertia::render('Products/Form', [
            'product' => $product->with(['inventory', 'unitConversions.fromUnit', 'unitConversions.toUnit'])->where('id', $product->id)->first(),
            'brands' => $brands,
            'tags' => $tags,
            'units' => Unit::orderBy('unit_name')->get(),
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
        $unit_conversions = $request->validated()['unit_conversions'];
        $product->unitConversions()->delete();
        foreach ($unit_conversions as $unit_conversion) {
            $product->unitConversions()->create($unit_conversion);
        }
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

    public function export(Request $request)
    {
        $status = $request->status;

        return Excel::download(new ProductsExport($status), 'stock.xlsx');
    }
}

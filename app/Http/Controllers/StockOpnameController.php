<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateStockOpnameRequest;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\StockOpname;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StockOpnameController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = StockOpname::with(['brand', 'tag', 'inventory'])->orderBy('product_name')->get();

        return Inertia::render('StockOpnames/Index', [
            'products' => $products,
        ]);
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json([]);
        }

        $products = StockOpname::with(['brand', 'inventory'])
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
        $stockOpnames = StockOpname::with('user')->orderBy('date_opname', 'desc')->get();
        $product = Product::with(['tag', 'brand', 'inventory'])->find(request()->input('product_id'));
        $stockOpname = new StockOpname;
        $stockOpname->product_id = $product->id;

        return Inertia::render('StockOpnames/Form', [
            'stockOpname' => $stockOpname,
            'stockOpnames' => $stockOpnames,
            'product' => $product,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $data['user_id'] = auth()->id();

            if ($request->hasFile('proof_path')) {
                $file = $request->file('proof_path');
                $path = $file->store('uploads', 'public');
                $data['proof'] = $path;
            }
            $stockOpname = StockOpname::create($data);

            Inventory::updateOrCreate(
                ['product_id' => $stockOpname->product_id],
                ['quantity' => $stockOpname->final_stock]
            );

            return redirect()->route('products.index')
                ->with('success', 'Stok udah berhasil diubah nih.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockOpname $product): Response {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockOpname $product) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStockOpnameRequest $request, StockOpname $product) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockOpname $product) {}
}

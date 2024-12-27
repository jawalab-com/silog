<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $date_from = $request->date_from ?? date('Y-m-01');
        $date_to = $request->date_to ?? date('Y-m-t');
        $products = Product::with(['brand', 'tag', 'inventory'])->orderBy('product_name')->get();

        return Inertia::render('Report/Index', [
            'products' => $products,
        ]);
    }

    public function export()
    {
        return Excel::download(new ReportsExport, 'users.xlsx');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request) {}

    /**
     * Display the specified resource.
     */
    public function show(Product $product): Response {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product) {}
}

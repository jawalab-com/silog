<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplierRequest;
use App\Http\Requests\UpdateSupplierRequest;
use App\Models\Log;
use App\Models\Supplier;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = Supplier::with(['tag'])->orderBy('supplier_name')->get();

        return Inertia::render('Suppliers/Index', [
            'suppliers' => $suppliers,
        ]);
    }

    public function suggestions(Request $request)
    {
        $query = $request->input('q');

        if (! $query) {
            return response()->json([]);
        }

        $products = Supplier::where('supplier_name', 'LIKE', '%'.$query.'%')
            ->orderBy('supplier_name', 'asc')
            ->limit(10)
            ->get(['id as value', 'supplier_name as label']);

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('tag_name')->get();

        return Inertia::render('Suppliers/Form', [
            'supplier' => null,
            'tags' => $tags,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSupplierRequest $request)
    {
        try {
            $supplier = Supplier::create($request->validated());

            Log::create([
                'log_type' => 'supplier',
                'message' => 'Supplier dibuat',
                'severity' => 'info',
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'context' => json_encode($supplier),
            ]);

            return redirect()->route('suppliers.index')
                ->with('success', 'Supplier created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier): Response
    {
        return Inertia::render('Profile/Show', [
            'supplier' => $supplier,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $tags = Tag::orderBy('tag_name')->get();

        return Inertia::render('Suppliers/Form', [
            'supplier' => $supplier,
            'tags' => $tags,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSupplierRequest $request, Supplier $supplier)
    {
        $supplier->update($request->validated());

        Log::create([
            'log_type' => 'supplier',
            'message' => 'Supplier diubah',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode(['before' => $supplier, 'after' => $request->validated()]),
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        Log::create([
            'log_type' => 'supplier',
            'message' => 'Supplier dihapus',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode($supplier),
        ]);

        return redirect()->route('suppliers.index')
            ->with('success', 'Data deleted successfully.');
    }
}

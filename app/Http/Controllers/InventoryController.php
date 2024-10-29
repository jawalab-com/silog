<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $inventories = Product::with(['inventory', 'brand'])
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'brand_name' => $product->brand ? $product->brand->brand_name : 'Unknown',
                    'product_name' => $product->product_name,
                    'quantity' => $product->inventory ? $product->inventory->quantity : 0,
                    'updated_at' => $product->updated_at,
                ];
            });

        return Inertia::render('Inventories/Index', [
            'inventories' => $inventories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Room $room)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Room $room)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Room $room)
    {
        //
    }
}

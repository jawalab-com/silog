<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUnitRequest;
use App\Http\Requests\UpdateUnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $units = Unit::orderBy('unit_name')->get();

        return Inertia::render('Units/Index', [
            'units' => $units,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Units/Form', [
            'unit' => new Unit,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request)
    {
        try {
            $unit = Unit::create($request->validated());

            Log::create([
                'log_type' => 'unit',
                'message' => 'Satuan dibuat',
                'severity' => 'info',
                'user_id' => auth()->id(),
                'ip_address' => request()->ip(),
                'context' => json_encode($unit),
            ]);

            return redirect()->route('units.index')
                ->with('success', 'Unit created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit): Response
    {
        return Inertia::render('Profile/Show', [
            'unit' => $unit,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        return Inertia::render('Units/Form', [
            'unit' => $unit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        Log::create([
            'log_type' => 'unit',
            'message' => 'Satuan diubah',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode(['before' => $unit, 'after' => $request->validated()]),
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        Log::create([
            'log_type' => 'unit',
            'message' => 'Satuan diubah',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode(['before' => $unit, 'after' => $request->validated()]),
        ]);

        return redirect()->route('units.index')
            ->with('success', 'Data deleted successfully.');
    }
}

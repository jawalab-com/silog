<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomTypeRequest;
use App\Http\Requests\UpdateRoomTypeRequest;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $room_types = RoomType::orderBy('name')->get();

        return Inertia::render('RoomTypes/Index', [
            'room_types' => $room_types,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('RoomTypes/Form', [
            'room_type' => new RoomType,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomTypeRequest $request)
    {
        $request->validated();
        $data = $request->all();

        try {
            $data['photos'] = [];

            foreach ($request->photos as $photo) {
                if ($photo instanceof UploadedFile) {
                    // Handle new file upload
                    $path = $photo->store('photos', 'public');
                    $data['photos'][] = $path;
                } else {
                    // Existing photo path
                    $data['photos'][] = $photo;
                }
            }

            RoomType::create($data);

            return redirect()->route('room-types.index')
                ->with('success', 'RoomType created successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to store data. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(RoomType $room_type): Response
    {
        return Inertia::render('Profile/Show', [
            'room_type' => $room_type,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RoomType $room_type)
    {
        return Inertia::render('RoomTypes/Form', [
            'room_type' => $room_type,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomTypeRequest $request, RoomType $room_type)
    {
        $room_type->update($request->validated());

        // Remove photos from storage and update the photos array
        if (! empty($request['removed_photos'])) {
            foreach ($request['removed_photos'] as $photoPath) {
                // Delete the photo from storage
                Storage::disk('public')->delete($photoPath);

                // Remove the photo path from the roomType's photos array
                if (($key = array_search($photoPath, $room_type->photos)) !== false) {
                    unset($room_type->photos[$key]);
                }
            }

            // Reindex the photos array
            $room_type->photos = array_values($room_type->photos);
        }

        return redirect()->route('room-types.index')
            ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RoomType $room_type)
    {
        $room_type->delete();

        return redirect()->route('room-types.index')
            ->with('success', 'Data deleted successfully.');
    }
}

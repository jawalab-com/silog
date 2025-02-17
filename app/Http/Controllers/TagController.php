<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Log;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tags = Tag::orderBy('tag_name')->get();

        return Inertia::render('Tags/Index', [
            'tags' => $tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Tags/Form', [
            'tag' => null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        // try {
        $tag = Tag::create($request->validated());

        Log::create([
            'log_type' => 'tag',
            'message' => 'Kategori dibuat',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode($tag),
        ]);

        return redirect()->route('tags.index')
            ->with('success', 'Tag created successfully.');
        // } catch (\Exception $e) {
        //     return redirect()->back()
        //         ->with('error', 'Failed to store data. Please try again.');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Tag $tag): Response
    {
        return Inertia::render('Profile/Show', [
            'tag' => $tag,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        return Inertia::render('Tags/Form', [
            'tag' => $tag,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());

        Log::create([
            'log_type' => 'tag',
            'message' => 'Kategori diubah',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode(['before' => $tag, 'after' => $request->validated()]),
        ]);

        return redirect()->route('tags.index')
            ->with('success', 'Data updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();

        Log::create([
            'log_type' => 'tag',
            'message' => 'Kategori dihapus',
            'severity' => 'info',
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'context' => json_encode($tag),
        ]);

        return redirect()->route('tags.index')
            ->with('success', 'Data deleted successfully.');
    }
}

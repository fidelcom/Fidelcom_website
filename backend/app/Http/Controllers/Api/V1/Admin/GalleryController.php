<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GalleryResource;
use App\Models\Gallery;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => GalleryResource::collection(Gallery::latest()->get())]);
    }

    public function show(Gallery $gallery): JsonResponse
    {
        return response()->json(['data' => new GalleryResource($gallery)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['nullable', 'string', 'max:255'],
            'image'    => ['required', 'image', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $media = $this->images->store(
            $request->file('image'),
            'gallery',
            1920,
            1280,
            $data['alt_text'] ?? null
        );

        $gallery = Gallery::create([
            'name'     => $data['name'] ?? null,
            'image'    => $media->url,
            'alt_text' => $media->alt_text,
        ]);

        return response()->json(['data' => new GalleryResource($gallery)], 201);
    }

    public function update(Request $request, Gallery $gallery): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['nullable', 'string', 'max:255'],
            'image'    => ['nullable', 'image', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($gallery->image);
            $media         = $this->images->store($request->file('image'), 'gallery', 1920, 1280, $data['alt_text'] ?? null);
            $data['image'] = $media->url;
        }

        $gallery->update($data);

        return response()->json(['data' => new GalleryResource($gallery)]);
    }

    public function destroy(Gallery $gallery): JsonResponse
    {
        $this->images->deletePath($gallery->image);
        $gallery->delete();

        return response()->json(null, 204);
    }
}

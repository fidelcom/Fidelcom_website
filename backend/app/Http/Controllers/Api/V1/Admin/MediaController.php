<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MediaResource;
use App\Models\Media;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(Request $request): JsonResponse
    {
        $media = Media::latest()
            ->when($request->get('q'), fn ($q, $search) => $q->where('filename', 'like', "%{$search}%"))
            ->paginate(40);

        return response()->json([
            'data' => MediaResource::collection($media->items()),
            'meta' => ['total' => $media->total(), 'last_page' => $media->lastPage(), 'current_page' => $media->currentPage()],
        ]);
    }

    public function upload(Request $request): JsonResponse
    {
        $request->validate([
            'file'     => ['required', 'image', 'max:10240'],
            'alt_text' => ['nullable', 'string', 'max:255'],
            'directory'=> ['nullable', 'string', 'max:50'],
        ]);

        $media = $this->images->store(
            $request->file('file'),
            $request->input('directory', 'media'),
            1920,
            1920,
            $request->input('alt_text')
        );

        return response()->json(['data' => new MediaResource($media)], 201);
    }

    public function update(Request $request, Media $medium): JsonResponse
    {
        $data = $request->validate([
            'alt_text' => ['nullable', 'string', 'max:255'],
        ]);

        $medium->update($data);

        return response()->json(['data' => new MediaResource($medium)]);
    }

    public function destroy(Media $medium): JsonResponse
    {
        $this->images->delete($medium);
        return response()->json(null, 204);
    }
}

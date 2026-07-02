<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use App\Services\ImageService;
use App\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(
        private ImageService $images,
        private SlugService $slugs,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $services = Service::when($request->get('q'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => ServiceResource::collection($services->items()),
            'meta' => [
                'total'        => $services->total(),
                'last_page'    => $services->lastPage(),
                'current_page' => $services->currentPage(),
            ],
        ]);
    }

    public function show(Service $service): JsonResponse
    {
        $service->load('multiImage');

        return response()->json(['data' => new ServiceResource($service)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'short_desc'       => ['required', 'string'],
            'long_desc'        => ['required', 'string'],
            'image'            => ['required', 'image', 'max:10240'],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        $media = $this->images->store($request->file('image'), 'service', 1920, 1080);

        $service = Service::create([
            ...$data,
            'image' => $media->url,
            'slug'  => $this->slugs->generate(Service::class, $data['title']),
        ]);

        return response()->json(['data' => new ServiceResource($service)], 201);
    }

    public function update(Request $request, Service $service): JsonResponse
    {
        $data = $request->validate([
            'title'            => ['sometimes', 'string', 'max:255'],
            'short_desc'       => ['sometimes', 'string'],
            'long_desc'        => ['sometimes', 'string'],
            'image'            => ['nullable', 'image', 'max:10240'],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($service->image);
            $media         = $this->images->store($request->file('image'), 'service', 1920, 1080);
            $data['image'] = $media->url;
        }

        if (isset($data['title'])) {
            $data['slug'] = $this->slugs->generate(Service::class, $data['title'], $service->id);
        }

        $service->update($data);

        return response()->json(['data' => new ServiceResource($service)]);
    }

    public function destroy(Service $service): JsonResponse
    {
        $this->images->deletePath($service->image);
        $service->delete();

        return response()->json(null, 204);
    }
}

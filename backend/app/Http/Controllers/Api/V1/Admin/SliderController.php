<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SliderResource;
use App\Models\Slider;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => SliderResource::collection(Slider::latest()->get())]);
    }

    public function show(Slider $slider): JsonResponse
    {
        return response()->json(['data' => new SliderResource($slider)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'project'     => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['required', 'image', 'max:10240'],
        ]);

        $media = $this->images->store($request->file('image'), 'slider', 1920, 1080);

        $slider = Slider::create([...$data, 'image' => $media->url]);

        return response()->json(['data' => new SliderResource($slider)], 201);
    }

    public function update(Request $request, Slider $slider): JsonResponse
    {
        $data = $request->validate([
            'title'       => ['sometimes', 'string', 'max:255'],
            'project'     => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:10240'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($slider->image);
            $media         = $this->images->store($request->file('image'), 'slider', 1920, 1080);
            $data['image'] = $media->url;
        }

        $slider->update($data);

        return response()->json(['data' => new SliderResource($slider)]);
    }

    public function destroy(Slider $slider): JsonResponse
    {
        $this->images->deletePath($slider->image);
        $slider->delete();

        return response()->json(null, 204);
    }
}

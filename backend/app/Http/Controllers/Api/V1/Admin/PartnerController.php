<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PartnerResource;
use App\Models\Partner;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => PartnerResource::collection(Partner::latest()->get())]);
    }

    public function show(Partner $partner): JsonResponse
    {
        return response()->json(['data' => new PartnerResource($partner)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'max:5120'],
            'url'   => ['nullable', 'url'],
        ]);

        $media = $this->images->store($request->file('image'), 'partner', 400, 200);

        $partner = Partner::create([...$data, 'image' => $media->url]);

        return response()->json(['data' => new PartnerResource($partner)], 201);
    }

    public function update(Request $request, Partner $partner): JsonResponse
    {
        $data = $request->validate([
            'name'  => ['sometimes', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'url'   => ['nullable', 'url'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($partner->image);
            $media         = $this->images->store($request->file('image'), 'partner', 400, 200);
            $data['image'] = $media->url;
        }

        $partner->update($data);

        return response()->json(['data' => new PartnerResource($partner)]);
    }

    public function destroy(Partner $partner): JsonResponse
    {
        $this->images->deletePath($partner->image);
        $partner->delete();

        return response()->json(null, 204);
    }
}

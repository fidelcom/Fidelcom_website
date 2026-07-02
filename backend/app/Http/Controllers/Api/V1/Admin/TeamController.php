<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TeamResource;
use App\Models\Team;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => TeamResource::collection(Team::latest()->get()),
        ]);
    }

    public function show(Team $team): JsonResponse
    {
        return response()->json(['data' => new TeamResource($team)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image'    => ['required', 'image', 'max:10240'],
            'facebook'  => ['nullable', 'url'],
            'twitter'   => ['nullable', 'url'],
            'linkedin'  => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
        ]);

        $media = $this->images->store($request->file('image'), 'team', 800, 800);

        $team = Team::create([...$data, 'image' => $media->url]);

        return response()->json(['data' => new TeamResource($team)], 201);
    }

    public function update(Request $request, Team $team): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'position' => ['sometimes', 'string', 'max:255'],
            'image'    => ['nullable', 'image', 'max:10240'],
            'facebook'  => ['nullable', 'url'],
            'twitter'   => ['nullable', 'url'],
            'linkedin'  => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($team->image);
            $media         = $this->images->store($request->file('image'), 'team', 800, 800);
            $data['image'] = $media->url;
        }

        $team->update($data);

        return response()->json(['data' => new TeamResource($team)]);
    }

    public function destroy(Team $team): JsonResponse
    {
        $this->images->deletePath($team->image);
        $team->delete();

        return response()->json(null, 204);
    }
}

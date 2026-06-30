<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use App\Services\ImageService;
use App\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(
        private ImageService $images,
        private SlugService $slugs,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $projects = Project::with('project_category')
            ->when($request->get('q'), fn ($q, $s) => $q->where('title', 'like', "%{$s}%"))
            ->when($request->get('category'), fn ($q, $cat) => $q->where('project_category_id', $cat))
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => ProjectResource::collection($projects->items()),
            'meta' => [
                'total'        => $projects->total(),
                'last_page'    => $projects->lastPage(),
                'current_page' => $projects->currentPage(),
            ],
        ]);
    }

    public function show(Project $project): JsonResponse
    {
        $project->load('project_category', 'multiImage');

        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'project_category_id' => ['required', 'exists:project_categories,id'],
            'title'               => ['required', 'string', 'max:255'],
            'short_desc'          => ['required', 'string'],
            'long_desc'           => ['required', 'string'],
            'client'              => ['nullable', 'string', 'max:255'],
            'year'                => ['nullable', 'integer'],
            'location'            => ['nullable', 'string', 'max:255'],
            'image'               => ['required', 'image', 'max:10240'],
            'meta_title'          => ['nullable', 'string', 'max:100'],
            'meta_description'    => ['nullable', 'string', 'max:300'],
        ]);

        $media = $this->images->store($request->file('image'), 'project', 1920, 1280);

        $project = Project::create([
            ...$data,
            'image' => $media->url,
            'slug'  => $this->slugs->generate(Project::class, $data['title']),
        ]);

        return response()->json(['data' => new ProjectResource($project)], 201);
    }

    public function update(Request $request, Project $project): JsonResponse
    {
        $data = $request->validate([
            'project_category_id' => ['sometimes', 'exists:project_categories,id'],
            'title'               => ['sometimes', 'string', 'max:255'],
            'short_desc'          => ['sometimes', 'string'],
            'long_desc'           => ['sometimes', 'string'],
            'client'              => ['nullable', 'string', 'max:255'],
            'year'                => ['nullable', 'integer'],
            'location'            => ['nullable', 'string', 'max:255'],
            'image'               => ['nullable', 'image', 'max:10240'],
            'meta_title'          => ['nullable', 'string', 'max:100'],
            'meta_description'    => ['nullable', 'string', 'max:300'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($project->image);
            $media          = $this->images->store($request->file('image'), 'project', 1920, 1280);
            $data['image']  = $media->url;
        }

        if (isset($data['title'])) {
            $data['slug'] = $this->slugs->generate(Project::class, $data['title'], $project->id);
        }

        $project->update($data);

        return response()->json(['data' => new ProjectResource($project)]);
    }

    public function destroy(Project $project): JsonResponse
    {
        $this->images->deletePath($project->image);
        $project->delete();

        return response()->json(null, 204);
    }
}

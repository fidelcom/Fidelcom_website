<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ProjectResource;
use App\Models\Project;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $projects = Project::with('project_category')
            ->when($request->get('category'), fn ($q, $cat) => $q->where('project_category_id', $cat))
            ->latest()
            ->paginate(12);

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
}

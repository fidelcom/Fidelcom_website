<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ProjectCategory::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:project_categories,name']]);
        $cat  = ProjectCategory::create($data);

        return response()->json(['data' => $cat->only('id', 'name')], 201);
    }

    public function update(Request $request, ProjectCategory $projectCategory): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:project_categories,name,' . $projectCategory->id]]);
        $projectCategory->update($data);

        return response()->json(['data' => $projectCategory->only('id', 'name')]);
    }

    public function destroy(ProjectCategory $projectCategory): JsonResponse
    {
        $projectCategory->delete();

        return response()->json(null, 204);
    }
}

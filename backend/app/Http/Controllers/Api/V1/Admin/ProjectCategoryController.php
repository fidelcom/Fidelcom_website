<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => ProjectCategory::orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:project_categories,name']]);
        $data['slug'] = Str::slug($data['name']);
        $cat  = ProjectCategory::create($data);

        return response()->json(['data' => $cat->only('id', 'name', 'slug')], 201);
    }

    public function update(Request $request, ProjectCategory $projectCategory): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:project_categories,name,' . $projectCategory->id]]);
        $data['slug'] = Str::slug($data['name']);
        $projectCategory->update($data);

        return response()->json(['data' => $projectCategory->only('id', 'name', 'slug')]);
    }

    public function destroy(ProjectCategory $projectCategory): JsonResponse
    {
        $projectCategory->delete();

        return response()->json(null, 204);
    }
}

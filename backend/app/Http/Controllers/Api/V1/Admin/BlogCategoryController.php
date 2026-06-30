<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BlogCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => BlogCategory::orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:blog_categories,name']]);
        $cat  = BlogCategory::create($data);

        return response()->json(['data' => $cat->only('id', 'name')], 201);
    }

    public function update(Request $request, BlogCategory $blogCategory): JsonResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:255', 'unique:blog_categories,name,' . $blogCategory->id]]);
        $blogCategory->update($data);

        return response()->json(['data' => $blogCategory->only('id', 'name')]);
    }

    public function destroy(BlogCategory $blogCategory): JsonResponse
    {
        $blogCategory->delete();

        return response()->json(null, 204);
    }
}

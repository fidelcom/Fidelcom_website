<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\ProjectCategory;
use Illuminate\Http\JsonResponse;

class ProjectCategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = ProjectCategory::withCount(['project' => fn ($q) => $q->where('status', 'published')])
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        return response()->json(['data' => $categories]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;
use App\Models\Page;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    public function show(string $slug): JsonResponse
    {
        $page = Page::with(['blocks', 'ogImage'])
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => new PageResource($page)]);
    }
}

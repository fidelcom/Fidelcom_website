<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $search   = $request->get('q');
        $category = $request->get('category');

        $posts = Post::with('blog_category')
            ->withCount('comment')
            ->when($search, fn ($q) => $q->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_desc', 'like', "%{$search}%")
                  ->orWhere('long_desc', 'like', "%{$search}%");
            }))
            ->when($category, fn ($q) => $q->whereHas('blog_category', fn ($q) => $q->where('slug', $category)))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return response()->json([
            'data'  => PostResource::collection($posts->items()),
            'meta'  => [
                'current_page' => $posts->currentPage(),
                'last_page'    => $posts->lastPage(),
                'per_page'     => $posts->perPage(),
                'total'        => $posts->total(),
                'from'         => $posts->firstItem(),
                'to'           => $posts->lastItem(),
            ],
            'links' => [
                'first' => $posts->url(1),
                'last'  => $posts->url($posts->lastPage()),
                'prev'  => $posts->previousPageUrl(),
                'next'  => $posts->nextPageUrl(),
            ],
        ]);
    }

    public function show(string $slug): JsonResponse
    {
        $post = Post::with(['blog_category', 'comment'])
            ->where('slug', $slug)
            ->firstOrFail();

        return response()->json(['data' => new PostResource($post)]);
    }
}

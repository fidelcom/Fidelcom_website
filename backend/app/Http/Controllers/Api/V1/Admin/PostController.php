<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PostResource;
use App\Models\Post;
use App\Services\ImageService;
use App\Services\SlugService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct(
        private ImageService $images,
        private SlugService $slugs,
    ) {}

    public function index(Request $request): JsonResponse
    {
        $posts = Post::with('blog_category')
            ->withCount('comment')
            ->when($request->get('q'), fn ($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->when($request->get('category'), fn ($q, $cat) => $q->where('blog_category_id', $cat))
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => PostResource::collection($posts->items()),
            'meta' => ['total' => $posts->total(), 'last_page' => $posts->lastPage(), 'current_page' => $posts->currentPage()],
        ]);
    }

    public function show(Post $post): JsonResponse
    {
        $post->load('blog_category', 'comment');
        return response()->json(['data' => new PostResource($post)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'blog_category_id' => ['required', 'exists:blog_categories,id'],
            'title'            => ['required', 'string', 'max:255'],
            'author'           => ['required', 'string', 'max:255'],
            'short_desc'       => ['required', 'string'],
            'long_desc'        => ['required', 'string'],
            'image'            => ['required', 'image', 'max:10240'],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        $media = $this->images->store($request->file('image'), 'post', 1920, 1280);

        $post = Post::create([
            ...$data,
            'image' => $media->url,
            'slug'  => $this->slugs->generate(Post::class, $data['title']),
        ]);

        return response()->json(['data' => new PostResource($post)], 201);
    }

    public function update(Request $request, Post $post): JsonResponse
    {
        $data = $request->validate([
            'blog_category_id' => ['sometimes', 'exists:blog_categories,id'],
            'title'            => ['sometimes', 'string', 'max:255'],
            'author'           => ['sometimes', 'string', 'max:255'],
            'short_desc'       => ['sometimes', 'string'],
            'long_desc'        => ['sometimes', 'string'],
            'image'            => ['nullable', 'image', 'max:10240'],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($post->image);
            $media        = $this->images->store($request->file('image'), 'post', 1920, 1280);
            $data['image'] = $media->url;
        }

        if (isset($data['title'])) {
            $data['slug'] = $this->slugs->generate(Post::class, $data['title'], $post->id);
        }

        $post->update($data);

        return response()->json(['data' => new PostResource($post)]);
    }

    public function destroy(Post $post): JsonResponse
    {
        $this->images->deletePath($post->image);
        $post->delete();

        return response()->json(null, 204);
    }
}

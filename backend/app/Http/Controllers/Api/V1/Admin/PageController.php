<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PageResource;
use App\Models\Block;
use App\Models\Page;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PageController extends Controller
{
    private const BLOCK_TYPES = [
        'hero', 'content', 'services_grid', 'projects_grid', 'stats',
        'testimonials', 'blog_posts', 'team', 'faqs', 'cta_banner',
        'gallery', 'partners', 'contact_form', 'process_steps', 'slider', 'case_study',
    ];

    public function index(): JsonResponse
    {
        $pages = Page::withCount('blocks')->latest()->get();

        return response()->json([
            'data' => PageResource::collection($pages),
        ]);
    }

    public function show(Page $page): JsonResponse
    {
        $page->load(['blocks', 'ogImage']);

        return response()->json(['data' => new PageResource($page)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'title'            => ['required', 'string', 'max:255'],
            'slug'             => ['required', 'string', 'max:255', 'unique:pages,slug', 'regex:/^[a-z0-9-]+$/'],
            'status'           => ['sometimes', Rule::in(['draft', 'published'])],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        if (($data['status'] ?? 'draft') === 'published') {
            $data['published_at'] = now();
        }

        $page = Page::create($data);

        return response()->json(['data' => new PageResource($page)], 201);
    }

    public function update(Request $request, Page $page): JsonResponse
    {
        $data = $request->validate([
            'title'            => ['sometimes', 'string', 'max:255'],
            'slug'             => ['sometimes', 'string', 'max:255', Rule::unique('pages', 'slug')->ignore($page->id), 'regex:/^[a-z0-9-]+$/'],
            'status'           => ['sometimes', Rule::in(['draft', 'published'])],
            'meta_title'       => ['nullable', 'string', 'max:100'],
            'meta_description' => ['nullable', 'string', 'max:300'],
        ]);

        if (isset($data['status']) && $data['status'] === 'published' && ! $page->published_at) {
            $data['published_at'] = now();
        }

        $page->update($data);

        return response()->json(['data' => new PageResource($page->fresh())]);
    }

    public function destroy(Page $page): JsonResponse
    {
        $page->delete();
        return response()->json(null, 204);
    }

    // ── Block management ──────────────────────────────────────────────────────

    public function storeBlock(Request $request, Page $page): JsonResponse
    {
        $data = $request->validate([
            'block_type' => ['required', Rule::in(self::BLOCK_TYPES)],
            'data'       => ['nullable', 'array'],
        ]);

        $position = $page->blocks()->max('position') + 1;

        $block = $page->blocks()->create([
            'block_type' => $data['block_type'],
            'position'   => $position,
            'data'       => $data['data'] ?? [],
        ]);

        return response()->json(['data' => [
            'id'         => $block->id,
            'block_type' => $block->block_type,
            'position'   => $block->position,
            'data'       => $block->data,
        ]], 201);
    }

    public function updateBlock(Request $request, Block $block): JsonResponse
    {
        $data = $request->validate([
            'data' => ['required', 'array'],
        ]);

        $block->update(['data' => $data['data']]);

        return response()->json(['data' => [
            'id'         => $block->id,
            'block_type' => $block->block_type,
            'position'   => $block->position,
            'data'       => $block->data,
        ]]);
    }

    public function destroyBlock(Block $block): JsonResponse
    {
        $block->delete();
        return response()->json(null, 204);
    }

    public function reorderBlocks(Request $request, Page $page): JsonResponse
    {
        $request->validate([
            'order'          => ['required', 'array'],
            'order.*.id'     => ['required', 'integer'],
            'order.*.position' => ['required', 'integer', 'min:0'],
        ]);

        DB::transaction(function () use ($request, $page) {
            foreach ($request->order as $item) {
                Block::where('id', $item['id'])
                    ->where('page_id', $page->id)
                    ->update(['position' => $item['position']]);
            }
        });

        return response()->json(['data' => ['message' => 'Blocks reordered']]);
    }
}

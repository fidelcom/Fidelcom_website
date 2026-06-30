<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MenuResource;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    public function index(): JsonResponse
    {
        $menus = Menu::with([
            'items' => fn ($q) => $q->whereNull('parent_id')->with('children')->orderBy('position'),
        ])->get();

        return response()->json(['data' => MenuResource::collection($menus)]);
    }

    public function show(Menu $menu): JsonResponse
    {
        $menu->load(['items' => fn ($q) => $q->whereNull('parent_id')->with('children')->orderBy('position')]);

        return response()->json(['data' => new MenuResource($menu)]);
    }

    public function updateItems(Request $request, Menu $menu): JsonResponse
    {
        $request->validate([
            'items'                   => ['required', 'array'],
            'items.*.label'           => ['required', 'string', 'max:255'],
            'items.*.url'             => ['required', 'string', 'max:500'],
            'items.*.target'          => ['nullable', 'in:_self,_blank'],
            'items.*.children'        => ['nullable', 'array'],
            'items.*.children.*.label' => ['required', 'string', 'max:255'],
            'items.*.children.*.url'   => ['required', 'string', 'max:500'],
            'items.*.children.*.target' => ['nullable', 'in:_self,_blank'],
        ]);

        DB::transaction(function () use ($request, $menu) {
            $menu->items()->delete();

            foreach ($request->input('items') as $position => $itemData) {
                $item = $menu->items()->create([
                    'label'     => $itemData['label'],
                    'url'       => $itemData['url'],
                    'target'    => $itemData['target'] ?? '_self',
                    'position'  => $position,
                    'parent_id' => null,
                ]);

                foreach ($itemData['children'] ?? [] as $childPos => $childData) {
                    $menu->items()->create([
                        'label'     => $childData['label'],
                        'url'       => $childData['url'],
                        'target'    => $childData['target'] ?? '_self',
                        'position'  => $childPos,
                        'parent_id' => $item->id,
                    ]);
                }
            }
        });

        $menu->load(['items' => fn ($q) => $q->whereNull('parent_id')->with('children')->orderBy('position')]);

        return response()->json(['data' => new MenuResource($menu)]);
    }
}

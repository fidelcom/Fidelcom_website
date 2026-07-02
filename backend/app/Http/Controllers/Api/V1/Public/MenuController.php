<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\MenuResource;
use App\Models\Menu;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $location = $request->get('location');

        $menus = Menu::with(['items' => fn ($q) => $q->whereNull('parent_id')->with('children')->orderBy('position')])
            ->when($location, fn ($q) => $q->where('location', $location))
            ->get();

        return response()->json(['data' => MenuResource::collection($menus)]);
    }
}

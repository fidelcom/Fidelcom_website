<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\JsonResponse;

class GalleryController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => GalleryResource::collection(Gallery::latest()->get()),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SliderResource;
use App\Models\Slider;
use Illuminate\Http\JsonResponse;

class SliderController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => SliderResource::collection(Slider::latest()->get()),
        ]);
    }
}

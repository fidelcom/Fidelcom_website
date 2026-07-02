<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TestimonialResource;
use App\Models\Testimonial;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $testimonials = Testimonial::where('approved', true)->latest()->get();

        return response()->json([
            'data' => TestimonialResource::collection($testimonials),
        ]);
    }
}

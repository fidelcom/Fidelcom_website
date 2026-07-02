<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;

class FaqController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => FaqResource::collection(Faq::latest()->get()),
        ]);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\PartnerResource;
use App\Models\Partner;
use Illuminate\Http\JsonResponse;

class PartnerController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => PartnerResource::collection(Partner::latest()->get()),
        ]);
    }
}

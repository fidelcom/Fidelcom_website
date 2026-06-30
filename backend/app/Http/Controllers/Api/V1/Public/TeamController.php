<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TeamResource;
use App\Models\Team;
use Illuminate\Http\JsonResponse;

class TeamController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => TeamResource::collection(Team::latest()->get()),
        ]);
    }
}

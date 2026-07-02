<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\ServiceResource;
use App\Models\Service;
use Illuminate\Http\JsonResponse;

class ServiceController extends Controller
{
    public function index(): JsonResponse
    {
        $services = Service::latest()->get();

        return response()->json(['data' => ServiceResource::collection($services)]);
    }

    public function show(Service $service): JsonResponse
    {
        $service->load('multiImage');

        return response()->json(['data' => new ServiceResource($service)]);
    }
}

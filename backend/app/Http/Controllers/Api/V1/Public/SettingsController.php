<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;

class SettingsController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => Setting::group('contact'),
        ]);
    }
}

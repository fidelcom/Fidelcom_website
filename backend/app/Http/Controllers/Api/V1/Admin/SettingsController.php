<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => [
                'contact' => Setting::group('contact'),
                'seo'     => Setting::group('seo'),
                'general' => Setting::group('general'),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $allowedGroups = ['general', 'seo', 'contact'];

        // Only accept known groups; each value in a group must be a scalar string
        $rules = ['*' => ['nullable', 'array']];
        foreach ($allowedGroups as $group) {
            $rules["{$group}.*"] = ['nullable', 'string', 'max:1000'];
        }

        $data = $request->validate($rules);

        foreach ($allowedGroups as $group) {
            if (isset($data[$group]) && is_array($data[$group])) {
                foreach ($data[$group] as $key => $value) {
                    // Restrict keys to alphanumeric + underscore to prevent injection
                    if (preg_match('/^[a-z0-9_]+$/i', $key)) {
                        Setting::set($key, (string) $value, $group);
                    }
                }
            }
        }

        return response()->json(['data' => ['message' => 'Settings saved']]);
    }
}

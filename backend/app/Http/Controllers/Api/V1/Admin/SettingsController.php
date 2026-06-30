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
        $data = $request->validate([
            'contact'              => ['nullable', 'array'],
            'contact.phone'        => ['nullable', 'string', 'max:50'],
            'contact.email'        => ['nullable', 'email', 'max:255'],
            'contact.address'      => ['nullable', 'string', 'max:500'],
            'contact.facebook'     => ['nullable', 'url', 'max:255'],
            'contact.twitter'      => ['nullable', 'url', 'max:255'],
            'contact.instagram'    => ['nullable', 'url', 'max:255'],
            'contact.linkedin'     => ['nullable', 'url', 'max:255'],
            'contact.youtube'      => ['nullable', 'url', 'max:255'],
            'seo'                  => ['nullable', 'array'],
            'seo.default_title'    => ['nullable', 'string', 'max:100'],
            'seo.default_desc'     => ['nullable', 'string', 'max:300'],
            'general'              => ['nullable', 'array'],
            'general.site_name'    => ['nullable', 'string', 'max:100'],
        ]);

        foreach ($data as $group => $settings) {
            if (! is_array($settings)) {
                continue;
            }
            foreach ($settings as $key => $value) {
                Setting::set($key, $value, $group);
            }
        }

        return response()->json(['data' => ['message' => 'Settings saved']]);
    }
}

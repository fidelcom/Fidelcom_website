<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\GetInTouch;
use App\Models\LetsTalk;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function contact(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        GetInTouch::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'] ?? '',
            'subject' => $data['subject'] ?? 'General Inquiry',
            'message' => $data['message'],
            'status'  => false,
        ]);

        return response()->json([
            'data' => ['message' => 'Your message has been sent successfully!'],
        ], 201);
    }

    public function quote(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['required', 'string', 'max:50'],
            'service' => ['required', 'string', 'max:255'],
            'budget'  => ['nullable', 'string', 'max:100'],
            'company' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = $data['message'];

        if (! empty($data['company'])) {
            $message = "Company: {$data['company']}\n\n" . $message;
        }

        if (! empty($data['budget'])) {
            $message .= "\n\nBudget: {$data['budget']}";
        }

        GetInTouch::create([
            'name'    => $data['name'],
            'email'   => $data['email'],
            'phone'   => $data['phone'],
            'subject' => "Quote Request – {$data['service']}",
            'message' => $message,
            'status'  => false,
        ]);

        return response()->json([
            'data' => ['message' => 'Your quote request has been received. We\'ll respond within 24 hours.'],
        ], 201);
    }
}

<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(['data' => FaqResource::collection(Faq::latest()->get())]);
    }

    public function show(Faq $faq): JsonResponse
    {
        return response()->json(['data' => new FaqResource($faq)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'question' => ['required', 'string', 'max:500'],
            'answer'   => ['required', 'string'],
        ]);

        $faq = Faq::create($data);

        return response()->json(['data' => new FaqResource($faq)], 201);
    }

    public function update(Request $request, Faq $faq): JsonResponse
    {
        $data = $request->validate([
            'question' => ['sometimes', 'string', 'max:500'],
            'answer'   => ['sometimes', 'string'],
        ]);

        $faq->update($data);

        return response()->json(['data' => new FaqResource($faq)]);
    }

    public function destroy(Faq $faq): JsonResponse
    {
        $faq->delete();

        return response()->json(null, 204);
    }
}

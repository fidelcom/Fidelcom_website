<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\TestimonialResource;
use App\Models\Testimonial;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function __construct(private ImageService $images) {}

    public function index(Request $request): JsonResponse
    {
        $testimonials = Testimonial::when(
                $request->boolean('pending'),
                fn ($q) => $q->where('approved', false),
            )
            ->latest()
            ->paginate(20);

        return response()->json([
            'data' => TestimonialResource::collection($testimonials->items()),
            'meta' => [
                'total'        => $testimonials->total(),
                'last_page'    => $testimonials->lastPage(),
                'current_page' => $testimonials->currentPage(),
            ],
        ]);
    }

    public function show(Testimonial $testimonial): JsonResponse
    {
        return response()->json(['data' => new TestimonialResource($testimonial)]);
    }

    public function store(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'image'    => ['nullable', 'image', 'max:5120'],
            'desc'     => ['required', 'string'],
            'rating'   => ['nullable', 'integer', 'min:1', 'max:5'],
            'approved' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $media         = $this->images->store($request->file('image'), 'testimonial', 400, 400);
            $data['image'] = $media->url;
        }

        $testimonial = Testimonial::create($data);

        return response()->json(['data' => new TestimonialResource($testimonial)], 201);
    }

    public function update(Request $request, Testimonial $testimonial): JsonResponse
    {
        $data = $request->validate([
            'name'     => ['sometimes', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'image'    => ['nullable', 'image', 'max:5120'],
            'desc'     => ['sometimes', 'string'],
            'rating'   => ['nullable', 'integer', 'min:1', 'max:5'],
            'approved' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            $this->images->deletePath($testimonial->image ?? '');
            $media         = $this->images->store($request->file('image'), 'testimonial', 400, 400);
            $data['image'] = $media->url;
        }

        $testimonial->update($data);

        return response()->json(['data' => new TestimonialResource($testimonial)]);
    }

    public function destroy(Testimonial $testimonial): JsonResponse
    {
        $this->images->deletePath($testimonial->image ?? '');
        $testimonial->delete();

        return response()->json(null, 204);
    }

    public function approve(Testimonial $testimonial): JsonResponse
    {
        $testimonial->update(['approved' => true]);

        return response()->json(['data' => new TestimonialResource($testimonial)]);
    }
}

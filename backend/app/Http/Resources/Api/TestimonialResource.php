<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'subtitle'   => $this->subtitle,
            'location'   => $this->location,
            'image'      => $this->image,
            'desc'       => $this->desc,
            'rating'     => $this->rating,
            'approved'   => $this->approved,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

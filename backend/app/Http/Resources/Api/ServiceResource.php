<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'short_desc'       => $this->short_desc,
            'long_desc'        => $this->long_desc,
            'image'            => $this->image,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'multi_images'     => $this->whenLoaded('multiImage', fn () =>
                $this->multiImage->map(fn ($img) => [
                    'id'    => $img->id,
                    'image' => $img->image,
                ])
            ),
            'created_at'       => $this->created_at?->toISOString(),
            'updated_at'       => $this->updated_at?->toISOString(),
        ];
    }
}

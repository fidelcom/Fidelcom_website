<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'status'           => $this->status,
            'published_at'     => $this->published_at?->toISOString(),
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'og_image'         => $this->whenLoaded('ogImage', fn () => $this->ogImage ? [
                'id'  => $this->ogImage->id,
                'url' => $this->ogImage->url,
            ] : null),
            'blocks'           => $this->whenLoaded('blocks', fn () =>
                $this->blocks->map(fn ($block) => [
                    'id'         => $block->id,
                    'block_type' => $block->block_type,
                    'position'   => $block->position,
                    'data'       => $block->data ?? [],
                ])
            ),
            'created_at'       => $this->created_at?->toISOString(),
            'updated_at'       => $this->updated_at?->toISOString(),
        ];
    }
}

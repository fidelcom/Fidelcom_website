<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'short_desc'       => $this->short_desc,
            'long_desc'        => $this->long_desc,
            'excerpt'          => $this->short_desc,
            'body'             => $this->long_desc,
            'client'           => $this->client,
            'year'             => $this->year,
            'location'         => $this->location,
            'url'              => null,
            'image'            => $this->image,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'project_category' => $this->whenLoaded('project_category', fn () => [
                'id'   => $this->project_category->id,
                'name' => $this->project_category->name,
            ]),
            'category'         => $this->whenLoaded('project_category', fn () => $this->project_category->name),
            'multi_images'     => $this->whenLoaded('multiImage', fn () =>
                $this->multiImage->map(fn ($img) => ['id' => $img->id, 'image' => $img->image])
            ),
            'multi_image'      => $this->whenLoaded('multiImage', fn () =>
                $this->multiImage->pluck('image')->all()
            ),
            'created_at'       => $this->created_at?->toISOString(),
            'updated_at'       => $this->updated_at?->toISOString(),
        ];
    }
}

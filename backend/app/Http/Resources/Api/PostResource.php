<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'               => $this->id,
            'title'            => $this->title,
            'slug'             => $this->slug,
            'author'           => $this->author,
            'short_desc'       => $this->short_desc,
            'long_desc'        => $this->long_desc,
            'image'            => $this->image,
            'meta_title'       => $this->meta_title,
            'meta_description' => $this->meta_description,
            'blog_category'    => $this->whenLoaded('blog_category', fn () => [
                'id'   => $this->blog_category->id,
                'name' => $this->blog_category->name,
                'slug' => $this->blog_category->slug ?? null,
            ]),
            'comments_count'   => $this->whenCounted('comment'),
            'created_at'       => $this->created_at?->toISOString(),
            'updated_at'       => $this->updated_at?->toISOString(),
        ];
    }
}

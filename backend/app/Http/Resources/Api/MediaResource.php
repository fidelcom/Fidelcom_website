<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'filename'   => $this->filename,
            'url'        => $this->url,
            'alt_text'   => $this->alt_text,
            'mime_type'  => $this->mime_type,
            'size'       => $this->size,
            'width'      => $this->width,
            'height'     => $this->height,
            'created_at' => $this->created_at?->toISOString(),
        ];
    }
}

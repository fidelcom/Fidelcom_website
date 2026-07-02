<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'position'   => $this->position,
            'image'      => $this->image,
            'facebook'   => $this->facebook,
            'twitter'    => $this->twitter,
            'linkedin'   => $this->linkedin,
            'instagram'  => $this->instagram,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}

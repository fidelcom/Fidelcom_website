<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'       => $this->id,
            'name'     => $this->name,
            'location' => $this->location,
            'items'    => $this->whenLoaded('items', fn () =>
                $this->items->map(fn ($item) => $this->formatItem($item))
            ),
        ];
    }

    private function formatItem($item): array
    {
        return [
            'id'       => $item->id,
            'label'    => $item->label,
            'url'      => $item->url,
            'target'   => $item->target,
            'position' => $item->position,
            'children' => $item->relationLoaded('children')
                ? $item->children->map(fn ($c) => $this->formatItem($c))->values()
                : [],
        ];
    }
}

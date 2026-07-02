<?php

namespace App\Services;

use Illuminate\Support\Str;

class SlugService
{
    public function generate(string $model, string $title, ?int $excludeId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i    = 1;

        while ($this->exists($model, $slug, $excludeId)) {
            $slug = "{$base}-{$i}";
            $i++;
        }

        return $slug;
    }

    private function exists(string $model, string $slug, ?int $excludeId): bool
    {
        $query = $model::where('slug', $slug);

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function project_category() : BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class);
    }

    public function multiImage() : HasMany
    {
        return $this->hasMany(ProjectMultiImage::class);
    }
}

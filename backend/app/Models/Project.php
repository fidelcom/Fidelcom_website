<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    use HasFactory;
    protected $fillable = [
        'project_category_id', 'title', 'slug', 'short_desc',
        'client', 'year', 'location', 'long_desc', 'image',
        'meta_title', 'meta_description', 'status',
    ];

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

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function blog_category() : BelongsTo
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function comment() : HasMany
    {
        return $this->hasMany(Comment::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;
    protected $fillable = [
        'title', 'slug', 'short_desc', 'long_desc', 'image',
        'meta_title', 'meta_description', 'status',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function multiImage() : HasMany
    {
        return $this->hasMany(ServiceMultiImage::class);
    }
}

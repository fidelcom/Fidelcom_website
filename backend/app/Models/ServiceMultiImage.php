<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ServiceMultiImage extends Model
{
    use HasFactory;
    protected $fillable = ['service_id', 'image'];

    public function services() : BelongsTo
    {
        return  $this->belongsTo(Service::class);
    }
}

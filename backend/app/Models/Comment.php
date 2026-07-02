<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'first_name', 'last_name', 'email', 'phone', 'message'];

    public function post() : BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}

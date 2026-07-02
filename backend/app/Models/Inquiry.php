<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    protected $fillable = [
        'source', 'name', 'email', 'phone',
        'subject', 'service', 'message', 'status',
    ];
}

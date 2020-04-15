<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Outbox extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'payload' => 'array',
        'published' => 'boolean'
    ];
}

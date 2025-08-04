<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $casts = [
        'text' => 'array',
    ];
}

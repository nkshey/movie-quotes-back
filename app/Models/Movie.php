<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Movie extends Model implements HasMedia
{
    use InteractsWithMedia;

    public $timestamps = false;

    protected $casts = [
        'title'       => 'array',
        'description' => 'array',
        'director'    => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function getImageAttribute(): ?string
    {
        return $this->getFirstMediaUrl('posters') ?: null;
    }
}

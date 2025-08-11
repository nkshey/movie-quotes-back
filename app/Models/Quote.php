<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Quote extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $casts = [
        'text' => 'array',
    ];

    public function scopeSearch(Builder $query, ?string $search): Builder
    {
        if (! $search) {
            return $query;
        }

        $jsonLike = function ($column, $term) {
            return function ($q) use ($column, $term) {
                $q->whereRaw(
                    "LOWER(JSON_UNQUOTE(JSON_EXTRACT($column, '$.en'))) LIKE ?",
                    ['%' . mb_strtolower($term) . '%']
                )->orWhereRaw(
                    "LOWER(JSON_UNQUOTE(JSON_EXTRACT($column, '$.ka'))) LIKE ?",
                    ['%' . mb_strtolower($term) . '%']
                );
            };
        };

        if (str_starts_with($search, '@')) {
            $term = mb_substr($search, 1);

            return $query->whereHas('movie', $jsonLike('title', $term));
        } elseif (str_starts_with($search, '#')) {
            $term = mb_substr($search, 1);

            return $query->where($jsonLike('text', $term));
        } else {
            return $query->where(function ($q) use ($search, $jsonLike) {
                $q->where($jsonLike('text', $search))
                    ->orWhereHas('movie', $jsonLike('title', $search));
            });
        }
    }

    public function getImageAttribute(): ?string
    {
        return $this->getFirstMediaUrl('quotes') ?: null;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function movie(): BelongsTo
    {
        return $this->belongsTo(Movie::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function likes(): HasMany
    {
        return $this->hasMany(Like::class);
    }
}

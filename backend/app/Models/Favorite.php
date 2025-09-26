<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    protected $fillable = [
        'user_id',
        'movie_id',
        'movie_title',
        'movie_poster',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

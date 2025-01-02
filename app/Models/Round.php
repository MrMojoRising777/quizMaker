<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Round extends Model
{
    protected $fillable = [
        'quiz_id',
        'title',
        'dev_slug',
        'type'
    ];

    public const ROUND_TYPES = 'round.types';

    public static function getRoundTypes(): array
    {
        return config(self::ROUND_TYPES);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}

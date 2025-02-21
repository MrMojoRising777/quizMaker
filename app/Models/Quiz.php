<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'type',
        'description',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rounds(): HasMany
    {
        return $this->hasMany(Round::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function averageRating()
    {
        return $this->reviews()->avg('rating');
    }

    public function isHostable(): bool
    {
        foreach ($this->rounds as $round) {
            foreach ($round->questions as $question) {
                if ($question->answers->isEmpty()) {
                    return false;
                }
            }
        }

        return true;
    }

    public function prepareRounds()
    {
        $rounds = [
            '3-6-9',
            'Open Deur',
//            'Puzzel',
//            'Collectief Geheugen',
//            'Finale',
        ];

        foreach($rounds as $round) {
            $devSlug = strtolower(str_replace(' ', '_', $round));

            Round::create([
                'quiz_id' => $this->id,
                'title' => $round,
                'dev_slug' => $devSlug,
            ]);
        }
    }
}

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

    public static function booted(): void
    {
        static::deleting(function ($quiz) {
            $quiz->rounds->each(function ($round) {
                $round->delete();
            });
        });
    }

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

    public function prepareRounds(): void
    {
        $rounds = [
            '3-6-9' => [
                'reward_interval' => 3,
                'reward_value' => 10,
            ],
            'Open Deur' => [
                'reward_value' => 20,
            ],
            'Puzzel' => [
                'reward_value' => 30,
            ],
            'Ingelijst' => [
                'reward_value' => 10,
            ],
            'Finale' => [
                'penalty' => -20,
            ],
        ];

        $roundData = [];
        $ruleData = [];

        foreach (array_keys($rounds) as $index => $round) {
            $roundData[] = [
                'quiz_id'   => $this->id,
                'title'     => $round,
                'order'     => $index + 1,
                'type'      => strtolower(str_replace(' ', '-', $round)),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Bulk insert rounds
        Round::insert($roundData);

        // Retrieve inserted rounds
        $insertedRounds = Round::where('quiz_id', $this->id)->get()->keyBy('title');

        foreach ($rounds as $roundName => $rules) {
            $roundId = $insertedRounds[$roundName]->id;

            foreach ($rules as $ruleName => $value) {
                $ruleData[] = [
                    'round_id'  => $roundId,
                    'rule_name' => $ruleName,
                    'value'     => $value,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Bulk insert rules
        RoundRule::insert($ruleData);
    }
}

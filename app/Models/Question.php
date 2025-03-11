<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    protected $fillable = [
        'round_id',
        'text',
        'file_path',
    ];

    public static function booted(): void
    {
        static::deleting(function ($question) {
            $question->answers()->delete();
        });
    }

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    static function createOrUpdate($roundId, array $data)
    {
        $new = self::where('round_id', $roundId)
            ->where('text', $data['text'])
            ->firstOrNew();

        $new->round_id  = $roundId;
        $new->text      = $data['text'];
        $new->note      = $data['note'] ?? null;
        $new->save();

        return $new;
    }
}

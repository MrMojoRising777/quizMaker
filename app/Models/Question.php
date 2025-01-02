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

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }

    static function createOrUpdate($roundId, $text)
    {
        $new = self::where('round_id', $roundId)->where('text', $text)->firstOrNew();
        $new->round_id = $roundId;
        $new->text = $text;
        $new->save();

        return $new;
    }
}

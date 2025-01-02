<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'text',
        'is_correct',
    ];

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    static function createOrUpdate($questionId, $text, $correct = true)
    {
        $new = self::where('question_id', $questionId)->where('text', $text)->firstOrNew();
        $new->round_id = $questionId;
        $new->text = $text;
        $new->correct = $correct;
        $new->save();

        return $new;
    }
}

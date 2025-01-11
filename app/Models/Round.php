<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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

    public function processThreeSixNine(array $data): void
    {
        $questions = array_filter($data['questions'] ?? []);
        $answers = $data['answers'] ?? [];

        foreach ($questions as $key => $text) {
            $question = Question::createOrUpdate($this->id, $text);

            foreach (array_filter((array)($answers[$key] ?? [])) as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }
    }

    public function processCollectiveMemory($questionKey, $questionData, $images, $answers): void
    {
        $questionText = $questionData['text'] ?? null;
        $file = $images[$questionKey] ?? null;
        $hasText = !empty($questionText);
        $hasImage = $file instanceof UploadedFile && $file->isValid();

        if (!$hasText && !$hasImage) {
            return;
        }

        $question = Question::createOrUpdate($this->id, $questionText);

        if ($hasImage) {
            $filePath = $file->store('uploads/round-images', 'public');
            $question->update(['file_path' => $filePath]);
        }

        if (!empty($answers[$questionKey])) {
            foreach ($answers[$questionKey] as $keyword) {
                Answer::createOrUpdate($question->id, $keyword);
            }
        }
    }

//    private function processDefaultRound($round, $questionKey, $questionData, $images, $answers): void
//    {
//        $questionText = is_array($questionData) ? ($questionData['text'] ?? null) : $questionData;
//        $hasText = !empty($questionText);
//
//        $file = $images[$questionKey] ?? null;
//        $hasImage = $file instanceof UploadedFile && $file->isValid();
//
//        if (!$hasText && !$hasImage) {
//            return;
//        }
//
//        $question = Question::createOrUpdate($round->id, $questionText);
//
//        $answerText = $answers[$questionKey] ?? null;
//        if (!empty($answerText)) {
//            Answer::createOrUpdate($question->id, $answerText);
//        }
//
//        // Save image if present
//        if ($hasImage) {
//            if($question->file_path) Storage::disk('public')->delete($question->file_path);
//            $filePath = $file->store('uploads/round-images', 'public');
//            $question->update(['file_path' => $filePath]);
//        }
//    }
}

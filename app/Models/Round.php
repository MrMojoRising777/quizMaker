<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\UploadedFile;

class Round extends Model
{
    protected $fillable = [
        'quiz_id',
        'title',
        'type',
        'order',
        'seconds',
    ];

    public const ROUND_TYPES = [
        '3-6-9',
        'open-deur',
        'puzzel',
        'ingelijst',
        'galerij',
        'collectief-geheugen',
        'finale',
    ];

    public static function booted(): void
    {
        static::deleting(function ($round) {
            $round->questions->each(function ($question) {
                $question->delete();
            });
        });
    }

    public static function getRoundTypes(): array
    {
        return config(self::ROUND_TYPES);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function rules(): HasMany
    {
        return $this->hasMany(RoundRule::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function processThreeSixNine(array $data): void
    {
        $questions = array_filter($data['questions'] ?? [], function ($question) {
            return !empty($question['text']) && !empty($question['answer']);
        });

        foreach ($questions as $questionData) {
            $text   = $questionData['text'];
            $answer = $questionData['answer'];
            $note   = $questionData['note'];

            $question = Question::createOrUpdate($this->id, [
                'text' => $text,
                'note' => $note,
            ]);

            if (!empty($answer)) {
                Answer::createOrUpdate($question->id, $answer);
            }
        }
    }

    public function processOpenDeur(array $data): void
    {
        $questions = array_filter($data['questions'] ?? [], function ($question) {
            return !empty($question['text']) && !empty($question['answers']);
        });

        foreach ($questions as $questionData) {
            $text = $questionData['text'];
            $filePath = !empty($questionData['image'])
                ? ImageHelper::saveImage($questionData['image'], 'questions')
                : null;

            $question = Question::createOrUpdate($this->id, $text);
            if ($filePath) {
                $question->update(['file_path' => $filePath]);
            }

            foreach (array_filter($questionData['answers']) as $answer) {
                Answer::createOrUpdate($question->id, $answer);
            }
        }
    }

    public function processPuzzel(array $data): void
    {
        $questions = array_filter($data['questions'] ?? [], function ($question) {
            return !empty($question['text']) && !empty($question['answers']);
        });

        foreach ($questions as $questionData) {
            $text = $questionData['text'];

            $question = Question::createOrUpdate($this->id, $text);

            foreach (array_filter($questionData['answers']) as $answer) {
                Answer::createOrUpdate($question->id, $answer);
            }
        }
    }

    public function processIngelijst(array $data): void
    {
        $questions = array_filter($data['questions'] ?? [], function ($question) {
            return !empty($question['text']) && !empty($question['answers']);
        });

        foreach ($questions as $questionData) {
            $text = $questionData['text'];

            $question = Question::createOrUpdate($this->id, $text);

            foreach (array_filter($questionData['answers']) as $answer) {
                Answer::createOrUpdate($question->id, $answer);
            }
        }
    }

//    optimize processing rounds, send round type along in array ["finale" => ["questions" => [..], "answers" => [..]]
    public function processFinale(array $data): void
    {
        $questions = array_filter($data['questions'] ?? [], function ($question) {
            return !empty($question['text']) && !empty($question['answers']);
        });

        foreach ($questions as $questionData) {
            $text = $questionData['text'];

            $question = Question::createOrUpdate($this->id, $text);

            foreach (array_filter($questionData['answers']) as $answer) {
                Answer::createOrUpdate($question->id, $answer);
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
}

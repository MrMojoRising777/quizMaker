<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'text'      => $this->text,
            'note'      => $this->note,
            'answers'   => AnswerResource::collection($this->whenLoaded('answers')), // Lazy load aware
            'file_path' => $this->file_path, // optional media
        ];
    }
}

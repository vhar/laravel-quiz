<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vhar\Quiz\Application\Views\QuizQuestionView;

/**
 * Class QuizQuestionResource
 *
 * Transforms QuizQuestionView DTO into an API JSON response.
 *
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 * @mixin QuizQuestionView
 */
final class QuizQuestionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var QuizQuestionView $this */
        return [
            'id' => $this->id,
            'quiz_id' => $this->quizId,
            'number' => $this->number,
            'title' => $this->title,
            'type' => $this->type, // Automatically serialized OptionData
            'score' => $this->score,
            'file' => $this->file,   // Automatically serialized FileData
            'video' => $this->video, // Automatically serialized VideoData
            'answers' => $this->answers, // Automatically serialized Collection of QuizAnswerView DTOs or null
        ];
    }
}
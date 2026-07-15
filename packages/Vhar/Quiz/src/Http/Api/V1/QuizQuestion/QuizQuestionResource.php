<?php

namespace Vhar\Quiz\Http\Api\V1\QuizQuestion;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vhar\Quiz\Application\Views\QuizQuestionView;

/**
 * Class QuizQuestionResource
 *
 * API resource wrapper for transmitting QuizQuestionView data.
 *
 * @property-read QuizQuestionView $resource
 * @package Vhar\Quiz\Http\Api\V1\QuizQuestion
 */
final class QuizQuestionResource extends JsonResource
{
    /**
     * QuizQuestionResource constructor.
     * * @param QuizQuestionView $resource
     */
    public function __construct(QuizQuestionView $resource)
    {
        parent::__construct($resource);
    }

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
        ];
    }
}
<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Vhar\Quiz\Application\Views\QuizView;

final class QuizResource extends JsonResource
{
    public function __construct(QuizView $resource)
    {
        parent::__construct($resource);
    }

    public function toArray(Request $request): array
    {
        /** @var QuizView $this */
        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'status' => $this->status,
            'title' => $this->title,
            'description' => $this->description,
            'author' => $this->author ? [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ] : null,
            'quiz_type' => $this->quizType,
            'quiz_duration_range' => $this->quizDurationRange,
            'age_restriction' => $this->ageRestriction,
            'attempt_limit' => $this->attemptLimit,
            'time_limit' => $this->timeLimit,
            'change_answer' => $this->changeAnswer,
            'scoring_type' => $this->scoringType,
            'quiz_settings' => $this->quizSettings,
            'passed' => $this->passed,
            'file' => $this->file,
        ];
    }
}
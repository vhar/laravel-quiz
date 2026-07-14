<?php

namespace Vhar\Quiz\Rules\Quiz;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Vhar\Quiz\Enums\QuizTypeEnum;

final class ScoringTypeRequiredForKnowledgeQuiz implements ValidationRule
{
    public function __construct(
        private readonly QuizTypeEnum $quizType,
    ) {
    }

    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail,
    ): void {
        if (
            $this->quizType === QuizTypeEnum::KNOWLEDGE
            && $value === null
        ) {
            $fail(
                'Scoring type is required for knowledge quizzes.'
            );
        }
    }
}
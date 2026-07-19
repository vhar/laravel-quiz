<?php

namespace Vhar\Quiz\Application\Views;

use Vhar\Quiz\Application\Data\FileData;
use Vhar\Quiz\Application\Data\OptionData;
use Vhar\Quiz\Application\Data\AuthorData;

final readonly class QuizView
{
    public function __construct(
        public int $id,
        public string $slug,
        public OptionData $status,
        public string $title,
        public ?string $description,
        public ?AuthorData $author,
        public OptionData $quizType,
        public ?OptionData $quizDurationRange,
        public OptionData $ageRestriction,
        public int $attemptLimit,
        public int $timeLimit,
        public bool $changeAnswer,
        public ?OptionData $scoringType,
        public ?array $quizSettings,
        public int $passed,

        public ?FileData $file = null,
    ) {
    }
}
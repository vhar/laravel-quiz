<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Application\Views\QuizView;
use Vhar\Quiz\Application\Data\AuthorData;

final readonly class QuizViewMapper
{
    public function __construct(
        private FileDataMapper $fileDataMapper,
        private OptionDataMapper $optionDataMapper,
    ) {
    }

    public function fromModel(Quiz $quiz): QuizView
    {
        $file = $quiz->relationLoaded('files')
            ? $quiz->files->first()
            : $quiz->file();

        return new QuizView(
            id: $quiz->id,

            slug: $quiz->slug,

            status: $this->optionDataMapper->fromEnum(
                $quiz->status
            ),

            title: $quiz->title,

            description: $quiz->description,

            author: $this->mapAuthor($quiz),

            quizType: $this->optionDataMapper->fromEnum(
                $quiz->quiz_type
            ),

            quizDurationRange: $quiz->durationRange
            ? $this->optionDataMapper->fromModel(
                $quiz->durationRange,
                labelField: 'title',
            )
            : null,

            ageRestriction: $this->optionDataMapper->fromEnum(
                $quiz->age_restriction
            ),

            attemptLimit: $quiz->attempt_limit,

            timeLimit: $quiz->time_limit,

            changeAnswer: $quiz->change_answer,

            scoringType: $quiz->scoring_type
            ? $this->optionDataMapper->fromEnum(
                $quiz->scoring_type
            )
            : null,

            quizSettings: $quiz->quiz_settings,

            passed: $quiz->passed,

            file: $file
            ? $this->fileDataMapper->fromModel($file)
            : null,
        );
    }

    private function mapAuthor(Quiz $quiz): ?AuthorData
    {
        if ($quiz->user === null) {
            return null;
        }

        return new AuthorData(
            id: $quiz->user->getAuthIdentifier(),
            name: (string) data_get(
                $quiz->user,
                config('quiz.author.name_attribute')
            ),
        );
    }
}
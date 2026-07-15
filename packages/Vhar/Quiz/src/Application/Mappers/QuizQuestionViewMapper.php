<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\Quiz\Models\QuizQuestion;
use Vhar\Quiz\Application\Views\QuizQuestionView;
use Vhar\Quiz\Enums\QuizQuestionTypeEnum;

/**
 * Class QuizQuestionViewMapper
 *
 * Maps QuizQuestion Eloquent model into a QuizQuestionView DTO.
 * Handles performance optimizations for loaded collections.
 *
 * @package Vhar\Quiz\Application\Mappers
 */
final readonly class QuizQuestionViewMapper
{
    /**
     * QuizQuestionViewMapper constructor.
     *
     * @param FileDataMapper $fileDataMapper Mapper for file records.
     * @param VideoDataMapper $videoDataMapper Mapper for video records.
     * @param OptionDataMapper $optionDataMapper Mapper for enum/model conversions.
     */
    public function __construct(
        private FileDataMapper $fileDataMapper,
        private VideoDataMapper $videoDataMapper,
        private OptionDataMapper $optionDataMapper,
    ) {
    }

    /**
     * Map a QuizQuestion model to QuizQuestionView.
     *
     * @param QuizQuestion $question The Eloquent model instance.
     * @return QuizQuestionView The mapped view representation.
     */
    public function fromModel(QuizQuestion $question): QuizQuestionView
    {
        // Safe file retrieval from memory collection to prevent N+1 queries
        $file = $question->relationLoaded('files')
            ? $question->files->first()
            : $question->file();

        // Safe video retrieval from memory collection to prevent N+1 queries
        $video = $question->relationLoaded('videos')
            ? $question->videos->first()
            : $question->video();

        return new QuizQuestionView(
            id: $question->id,
            quizId: $question->quiz_id,
            number: $question->number,
            title: $question->title,
            type: $this->optionDataMapper->fromEnum(
                QuizQuestionTypeEnum::from($question->type)
            ),
            score: $question->score,
            file: $file
            ? $this->fileDataMapper->fromModel($file)
            : null,
            video: $video
            ? $this->videoDataMapper->fromModel($video)
            : null,
        );
    }
}
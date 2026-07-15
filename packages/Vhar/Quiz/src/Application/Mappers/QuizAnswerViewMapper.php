<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\Quiz\Application\Views\QuizAnswerView;
use Vhar\Quiz\Models\QuizQuestionAnswer;

/**
 * Class QuizAnswerViewMapper
 *
 * Maps a QuizQuestionAnswer Eloquent model into a QuizAnswerView DTO.
 *
 * @package Vhar\Quiz\Application\Mappers
 */
final readonly class QuizAnswerViewMapper
{
    /**
     * QuizAnswerViewMapper constructor.
     *
     * @param FileDataMapper $fileDataMapper Mapper for attached media files.
     */
    public function __construct(
        private FileDataMapper $fileDataMapper,
    ) {
    }

    /**
     * Map a QuizQuestionAnswer Eloquent model to a QuizAnswerView DTO.
     *
     * @param QuizQuestionAnswer $answer The Eloquent model instance.
     * @return QuizAnswerView The mapped DTO representation.
     */
    public function fromModel(QuizQuestionAnswer $answer): QuizAnswerView
    {
        // Safe file retrieval from memory collection to prevent N+1 queries
        $file = $answer->relationLoaded('files')
            ? $answer->files->first()
            : $answer->file();

        return new QuizAnswerView(
            id: $answer->id,
            questionId: $answer->quiz_question_id,
            title: $answer->title,
            isCorrect: isset($answer->is_correct) ? (bool) $answer->is_correct : null,
            file: $file
            ? $this->fileDataMapper->fromModel($file)
            : null,
        );
    }
}
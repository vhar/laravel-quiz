<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion;

use Illuminate\Support\Facades\DB;
use Vhar\Quiz\Application\Mappers\QuizQuestionViewMapper;
use Vhar\Quiz\Application\Views\QuizQuestionView;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class UpdateQuestionHandler
 *
 * Handles the business logic for updating an existing quiz question,
 * with smart video asset management.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\UpdateQuestion
 */
final readonly class UpdateQuestionHandler
{
    /**
     * UpdateQuestionHandler constructor.
     *
     * @param QuizQuestionViewMapper $questionViewMapper Mapper to convert model to read-view DTO.
     */
    public function __construct(
        private QuizQuestionViewMapper $questionViewMapper,
    ) {
    }

    /**
     * Execute the update question command.
     *
     * @param UpdateQuestionCommand $command The command containing updated question details.
     * @return QuizQuestionView The updated question view representation.
     */
    public function handle(UpdateQuestionCommand $command): QuizQuestionView
    {
        return DB::transaction(function () use ($command) {
            /** @var QuizQuestion $question */
            $question = QuizQuestion::findOrFail($command->questionId);

            $question->update([
                'number' => $command->number,
                'title' => $command->title,
                'type' => $command->type->value,
                'score' => $command->score,
            ]);

            // Smart video updates: check database to avoid redundant queries
            $currentVideo = $question->video();

            if ($command->videoUrl !== null) {
                // If a new URL is provided, and it differs from the existing one (or no video exists yet)
                if ($currentVideo === null || $currentVideo->url !== $command->videoUrl) {
                    $question->videos()->delete();
                    $question->addVideo($command->videoUrl);
                }
            } else {
                // If the URL is explicitly set to null/empty, clear existing videos
                $question->videos()->delete();
            }

            $question = $question->fresh();

            // Eager load relations to optimize mapping performance
            $question->load([
                'files',
                'videos',
            ]);

            return $this->questionViewMapper->fromModel($question);
        });
    }
}
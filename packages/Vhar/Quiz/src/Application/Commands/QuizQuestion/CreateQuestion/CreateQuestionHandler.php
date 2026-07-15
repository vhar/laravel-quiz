<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion;

use Illuminate\Support\Facades\DB;
use Vhar\Quiz\Application\Mappers\QuizQuestionViewMapper;
use Vhar\Quiz\Application\Views\QuizQuestionView;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class CreateQuestionHandler
 *
 * Resolves business requirements to create questions and attach initial videos within database transactions.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion
 */
final readonly class CreateQuestionHandler
{
    /**
     * CreateQuestionHandler constructor.
     *
     * @param QuizQuestionViewMapper $questionViewMapper Model-to-View DTO conversion mapper.
     */
    public function __construct(
        private QuizQuestionViewMapper $questionViewMapper,
    ) {
    }

    /**
     * Execute database operations to create a new question.
     *
     * @param CreateQuestionCommand $command Parameters for creation.
     * @return QuizQuestionView Read-Model representation of the newly created question.
     */
    public function handle(CreateQuestionCommand $command): QuizQuestionView
    {
        return DB::transaction(function () use ($command) {
            /** @var QuizQuestion $question */
            $question = QuizQuestion::create([
                'quiz_id' => $command->quizId,
                'number' => $command->number,
                'title' => $command->title,
                'type' => $command->type->value,
                'score' => $command->score,
            ]);

            // If an external video URL is provided, associate it during creation
            if ($command->videoUrl !== null) {
                $question->addVideo($command->videoUrl);
            }

            $question = $question->fresh();

            // Load relations to optimize memory usage during mapping
            $question->load([
                'files',
                'videos',
            ]);

            return $this->questionViewMapper->fromModel($question);
        });
    }
}
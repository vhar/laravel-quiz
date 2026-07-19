<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion;

use Illuminate\Support\Facades\DB;
use RuntimeException;
use Vhar\Quiz\Application\Mappers\QuizQuestionViewMapper;
use Vhar\Quiz\Application\Views\QuizQuestionView;
use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Models\QuizDiagnosticKey;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class CreateQuestionHandler
 *
 * Handles database operations to create a new quiz question and attaches 
 * external video streams while enforcing diagnostic preconditions.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\CreateQuestion
 */
final readonly class CreateQuestionHandler
{
    /**
     * CreateQuestionHandler constructor.
     *
     * @param QuizQuestionViewMapper $questionViewMapper Mapper to convert model to view representation.
     */
    public function __construct(
        private QuizQuestionViewMapper $questionViewMapper
    ) {
    }

    /**
     * Execute database operations to create a new question.
     *
     * @param CreateQuestionCommand $command Parameters for creation.
     * @return QuizQuestionView Read-Model representation of the newly created question.
     *
     * @throws RuntimeException If target quiz is missing or fails diagnostic preconditions.
     */
    public function handle(CreateQuestionCommand $command): QuizQuestionView
    {
        /** @var Quiz|null $quiz */
        $quiz = Quiz::find($command->quizId);

        if (!$quiz) {
            throw new RuntimeException("Target quiz with ID {$command->quizId} was not found.");
        }

        // Business Rule: A diagnostic quiz (type 2) must possess at least one key before introducing questions
        if ((int) $quiz->type === 2) {
            $hasKeys = QuizDiagnosticKey::where('quiz_id', $quiz->id)->exists();

            if (!$hasKeys) {
                throw new RuntimeException(
                    "Cannot add questions to a diagnostic quiz that does not have any diagnostic keys configured."
                );
            }
        }

        return DB::transaction(function () use ($command) {
            /** @var QuizQuestion $question */
            $question = QuizQuestion::create([
                'quiz_id' => $command->quizId,
                'number' => $command->number,
                'title' => $command->title,
                'type' => $command->type->value,
                'score' => $command->score,
            ]);

            // If an external video URL is provided, associate it during creation via dedicated package method
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
<?php

namespace Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion;

use Illuminate\Support\Facades\DB;
use Vhar\LaravelFiles\Facades\LaravelFiles;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class DeleteQuestionHandler
 *
 * Handles the business logic for deleting a quiz question,
 * ensuring all associated media assets (files and videos) are detached.
 *
 * @package Vhar\Quiz\Application\Commands\QuizQuestion\DeleteQuestion
 */
final readonly class DeleteQuestionHandler
{
    /**
     * Execute the delete question command.
     *
     * @param DeleteQuestionCommand $command Command details.
     * @return void
     */
    public function handle(DeleteQuestionCommand $command): void
    {
        DB::transaction(function () use ($command) {
            /** @var QuizQuestion $question */
            $question = QuizQuestion::findOrFail($command->questionId);

            // 1. Detach all attached files using LaravelFiles facade
            $question->files->each(function ($file) use ($question) {
                LaravelFiles::detach($question, $file);
            });

            // 2. Clean up polymorphic video links
            $question->videos()->delete();

            // 3. Delete the question itself
            $question->delete();
        });
    }
}
<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey;

use Illuminate\Support\Facades\DB;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class DeleteDiagnosticKeyHandler
 *
 * Handles the business logic for safely removing an existing diagnostic key.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\DeleteDiagnosticKey
 */
final readonly class DeleteDiagnosticKeyHandler
{
    /**
     * Execute database routines to delete the diagnostic key.
     *
     * @param DeleteDiagnosticKeyCommand $command
     * @return void
     */
    public function handle(DeleteDiagnosticKeyCommand $command): void
    {
        DB::transaction(function () use ($command) {
            /** @var QuizDiagnosticKey $key */
            $key = QuizDiagnosticKey::where('quiz_id', $command->quizId)
                ->findOrFail($command->id);

            // If the package utilizes a file storage layer, clean up entity files before purge
            if (method_exists($key, 'files')) {
                $key->files()->delete();
            }

            $key->delete();
        });
    }
}
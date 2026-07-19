<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey;

use Illuminate\Support\Facades\DB;
use Vhar\Quiz\Application\Mappers\QuizDiagnosticKeyViewMapper;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class CreateDiagnosticKeyHandler
 *
 * Handles the business logic for atomic creation of a diagnostic key and its associated level metrics.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\CreateDiagnosticKey
 */
final readonly class CreateDiagnosticKeyHandler
{
    /**
     * CreateDiagnosticKeyHandler constructor.
     *
     * @param QuizDiagnosticKeyViewMapper $mapper Model-to-View mapping adapter.
     */
    public function __construct(
        private QuizDiagnosticKeyViewMapper $mapper,
    ) {
    }

    /**
     * Execute database routines to store a diagnostic key and related levels safely.
     *
     * @param CreateDiagnosticKeyCommand $command
     * @return QuizDiagnosticKeyView
     */
    public function handle(CreateDiagnosticKeyCommand $command): QuizDiagnosticKeyView
    {
        return DB::transaction(function () use ($command) {
            /** @var QuizDiagnosticKey $key */
            $key = QuizDiagnosticKey::create([
                'quiz_id' => $command->quizId,
                'name' => $command->name,
                'description' => $command->description,
                'sort' => $command->sort,
            ]);

            // Create embedded required level bounds
            $key->levels()->createMany($command->levels);

            $key = $key->fresh();

            // Eager load relations to prepare data footprint for mapping layers
            $key->load([
                'levels',
                'files',
            ]);

            return $this->mapper->fromModel($key);
        });
    }
}
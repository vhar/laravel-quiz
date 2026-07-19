<?php

namespace Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey;

use Illuminate\Support\Facades\DB;
use Vhar\Quiz\Application\Mappers\QuizDiagnosticKeyViewMapper;
use Vhar\Quiz\Application\Views\QuizDiagnosticKeyView;
use Vhar\Quiz\Models\QuizDiagnosticKey;

/**
 * Class UpdateDiagnosticKeyHandler
 *
 * Handles atomic synchronization of an existing diagnostic key and its multi-level boundaries.
 *
 * @package Vhar\Quiz\Application\Commands\QuizDiagnosticKey\UpdateDiagnosticKey
 */
final readonly class UpdateDiagnosticKeyHandler
{
    /**
     * UpdateDiagnosticKeyHandler constructor.
     *
     * @param QuizDiagnosticKeyViewMapper $mapper Model-to-View mapping adapter.
     */
    public function __construct(
        private QuizDiagnosticKeyViewMapper $mapper,
    ) {
    }

    /**
     * Execute database routines to update the diagnostic key and synchronize its child levels.
     *
     * @param UpdateDiagnosticKeyCommand $command
     * @return QuizDiagnosticKeyView
     */
    public function handle(UpdateDiagnosticKeyCommand $command): QuizDiagnosticKeyView
    {
        return DB::transaction(function () use ($command) {
            /** @var QuizDiagnosticKey $key */
            $key = QuizDiagnosticKey::where('quiz_id', $command->quizId)
                ->findOrFail($command->id);

            $key->update([
                'name' => $command->name,
                'description' => $command->description,
                'sort' => $command->sort,
            ]);

            $keptIds = [];

            foreach ($command->levels as $levelData) {
                if (isset($levelData['id'])) {
                    // Update existing level metric
                    $key->levels()->where('id', $levelData['id'])->update([
                        'name' => $levelData['name'],
                        'description' => $levelData['description'],
                        'min_value' => $levelData['min_value'],
                        'max_value' => $levelData['max_value'],
                    ]);
                    $keptIds[] = $levelData['id'];
                } else {
                    // Create newly added level metric
                    $newLevel = $key->levels()->create([
                        'name' => $levelData['name'],
                        'description' => $levelData['description'],
                        'min_value' => $levelData['min_value'],
                        'max_value' => $levelData['max_value'],
                    ]);
                    $keptIds[] = $newLevel->id;
                }
            }

            // Purge historical levels removed by user in current layout state
            $key->levels()->whereNotIn('id', $keptIds)->delete();

            $key = $key->fresh();

            // Refootprint internal entity relationships for read-model presentation
            $key->load([
                'levels',
                'files',
            ]);

            return $this->mapper->fromModel($key);
        });
    }
}
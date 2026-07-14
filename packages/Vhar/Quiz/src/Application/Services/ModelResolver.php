<?php

namespace Vhar\Quiz\Application\Services;

use Illuminate\Database\Eloquent\Model;

/**
 * Resolves application models by configured aliases.
 */
final readonly class ModelResolver
{
    /**
     * Resolve target model.
     *
     * @param string $type Model alias.
     * @param int $id Model identifier.
     *
     * @return Model
     */
    public function resolve(
        string $type,
        int $id,
    ): Model {
        $modelClass = config(
            "quiz.fileable_models.{$type}"
        );

        return $modelClass::query()
            ->findOrFail($id);
    }
}
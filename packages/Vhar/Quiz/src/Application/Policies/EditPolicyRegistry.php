<?php

namespace Vhar\Quiz\Application\Policies;

use Illuminate\Database\Eloquent\Model;
use RuntimeException;

/**
 * Resolves edit policies for application models.
 *
 * Uses model-to-policy mapping from application configuration.
 */
final readonly class EditPolicyRegistry
{
    /**
     * Resolve edit policy for model.
     *
     * @param Model $model Target model.
     *
     * @return object Policy instance.
     *
     * @throws RuntimeException When policy is not registered.
     */
    public function resolve(
        Model $model,
    ): object {
        $modelClass = $model::class;

        $policyClass = config(
            "quiz.edit_policies.{$modelClass}"
        );

        if ($policyClass === null) {
            throw new RuntimeException(
                "Edit policy not registered for model [{$modelClass}]."
            );
        }

        return app($policyClass);
    }
}
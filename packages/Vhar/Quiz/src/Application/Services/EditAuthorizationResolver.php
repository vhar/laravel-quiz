<?php

namespace Vhar\Quiz\Application\Services;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Vhar\Quiz\Application\Policies\EditPolicyRegistry;

/**
 * Resolves edit authorization rules for application models.
 */
final readonly class EditAuthorizationResolver
{
    /**
     * Create authorization resolver.
     *
     * @param EditPolicyRegistry $registry Edit policy registry.
     */
    public function __construct(
        private EditPolicyRegistry $registry,
    ) {
    }

    /**
     * Check whether user can edit model.
     *
     * Resolves corresponding policy and checks edit permission.
     *
     * @param Model $model Model to edit.
     * @param Authenticatable $user Authenticated user.
     *
     * @return void
     *
     * @throws AuthorizationException When edit access is denied.
     */
    public function authorize(
        Model $model,
        Authenticatable $user,
    ): void {
        $policy = $this->registry->resolve($model);

        if (!$policy->allows($model, $user)) {
            throw new AuthorizationException(
                'You do not have permission to edit this resource.'
            );
        }
    }
}
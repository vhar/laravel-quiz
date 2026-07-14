<?php

namespace Vhar\Quiz\Application\Services;

use Illuminate\Database\Eloquent\Model;
use Vhar\LaravelFiles\Models\File;

/**
 * Resolves files attached to application models.
 */
final readonly class FileResolver
{
    /**
     * Resolve attached file.
     *
     * Finds a file only among files related to the given model.
     * This prevents removing or modifying files that are not attached
     * to the target model.
     *
     * @param Model $model Target model.
     * @param int $fileId File identifier.
     *
     * @return File
     */
    public function resolve(
        Model $model,
        int $fileId,
    ): File {
        return $model->files()
            ->where('files.id', $fileId)
            ->firstOrFail();
    }
}
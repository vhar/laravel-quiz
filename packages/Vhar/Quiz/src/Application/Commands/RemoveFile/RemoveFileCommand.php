<?php

namespace Vhar\Quiz\Application\Commands\RemoveFile;

use Illuminate\Database\Eloquent\Model;
use Vhar\LaravelFiles\Models\File;

/**
 * Command for removing file from model.
 */
final readonly class RemoveFileCommand
{
    /**
     * Create remove file command.
     *
     * @param Model $model Target model.
     * @param File $file File to remove.
     */
    public function __construct(
        public Model $model,
        public File $file,
    ) {
    }
}
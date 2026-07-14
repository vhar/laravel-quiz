<?php

namespace Vhar\Quiz\Application\Commands\RemoveFile;

use Vhar\LaravelFiles\Facades\LaravelFiles;

/**
 * Handles file removal.
 */
final readonly class RemoveFileHandler
{
    /**
     * Remove file from model.
     *
     * @param RemoveFileCommand $command Remove file command.
     *
     * @return void
     */
    public function handle(
        RemoveFileCommand $command,
    ): void {
        LaravelFiles::detach(
            $command->model,
            $command->file,
        );
    }
}
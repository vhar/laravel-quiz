<?php

namespace Vhar\Quiz\Application\Commands\File\ReplaceFile;

use Vhar\LaravelFiles\Facades\LaravelFiles;
use Vhar\LaravelFiles\Models\File;

/**
 * Handles file replacement.
 */
final readonly class ReplaceFileHandler
{
    /**
     * Replace existing file content.
     *
     * Keeps file identifier and existing model relations.
     *
     * @param ReplaceFileCommand $command Replace file command.
     *
     * @return File Updated file.
     */
    public function handle(
        ReplaceFileCommand $command,
    ): File {
        return LaravelFiles::replace(
            $command->file,
            $command->newFile,
        );
    }
}
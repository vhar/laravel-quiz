<?php

namespace Vhar\Quiz\Application\Commands\File\AttachFile;

use Vhar\LaravelFiles\Facades\LaravelFiles;
use Vhar\LaravelFiles\Models\File;

/**
 * Handles file attachment to models.
 */
final readonly class AttachFileHandler
{
    /**
     * Attach uploaded file to model.
     *
     * @param AttachFileCommand $command Attach file command.
     *
     * @return File Attached file.
     */
    public function handle(
        AttachFileCommand $command,
    ): File {
        $file = LaravelFiles::upload(
            $command->file,
        );

        LaravelFiles::attach(
            $command->model,
            $file,
        );

        return $file;
    }
}
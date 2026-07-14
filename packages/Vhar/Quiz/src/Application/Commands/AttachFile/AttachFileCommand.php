<?php

namespace Vhar\Quiz\Application\Commands\AttachFile;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;

/**
 * Command for attaching a file to an Eloquent model.
 */
final readonly class AttachFileCommand
{
    /**
     * Create attach file command.
     *
     * @param Model $model Model that will receive the file.
     * @param UploadedFile $file Uploaded file.
     */
    public function __construct(
        public Model $model,
        public UploadedFile $file,
    ) {
    }
}
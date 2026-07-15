<?php

namespace Vhar\Quiz\Application\Commands\File\ReplaceFile;

use Illuminate\Http\UploadedFile;
use Vhar\LaravelFiles\Models\File;

/**
 * Command for replacing file content.
 */
final readonly class ReplaceFileCommand
{
    /**
     * @param File $file Existing file record.
     * @param UploadedFile $newFile New uploaded file.
     */
    public function __construct(
        public File $file,
        public UploadedFile $newFile,
    ) {
    }
}
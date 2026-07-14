<?php

namespace Vhar\Quiz\Application\Mappers;

use Vhar\LaravelFiles\Models\File;
use Vhar\Quiz\Application\Data\FileData;

final class FileDataMapper
{
    public function fromModel(File $file): FileData
    {
        return new FileData(
            id: $file->id,
            url: $file->url(),
            originalName: $file->original_name,
            mimeType: $file->mime_type,
            size: $file->size,
            humanSize: $file->humanSize(),
        );
    }
}
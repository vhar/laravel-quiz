<?php

namespace Vhar\Quiz\Application\Data;

final readonly class FileData
{
    public function __construct(
        public int $id,
        public string $url,
        public string $originalName,
        public string $mimeType,
        public int $size,
        public string $humanSize,
    ) {
    }
}
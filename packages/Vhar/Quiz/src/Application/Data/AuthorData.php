<?php

namespace Vhar\Quiz\Application\Data;

final readonly class AuthorData
{
    public function __construct(
        public int|string $id,
        public string $name,
    ) {
    }
}
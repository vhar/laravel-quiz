<?php

namespace Vhar\Quiz\Application\Data;

final readonly class OptionData
{
    public function __construct(
        public int|string $value,
        public string $label,
    ) {
    }
}
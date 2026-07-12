<?php

namespace Vhar\Quiz\Enums;

enum QuizAgeRestrictionEnum: int
{
    case ZERO_PLUS = 0;
    case SIX_PLUS = 6;
    case TWELVE_PLUS = 12;
    case FOURTEEN_PLUS = 14;
    case SIXTEEN_PLUS = 16;
    case EIGHTEEN_PLUS = 18;

    public function readableOptions(): string
    {
        return match ($this) {
            self::ZERO_PLUS => '0+',
            self::SIX_PLUS => '6+',
            self::TWELVE_PLUS => '12+',
            self::FOURTEEN_PLUS => '14+',
            self::SIXTEEN_PLUS => '16+',
            self::EIGHTEEN_PLUS => '18+',
        };
    }

    public static function fromOption(string $option): self
    {
        return match ($option) {
            '0+' => self::ZERO_PLUS,
            '6+' => self::SIX_PLUS,
            '12+' => self::TWELVE_PLUS,
            '14+' => self::FOURTEEN_PLUS,
            '16+' => self::SIXTEEN_PLUS,
            '18+' => self::EIGHTEEN_PLUS,
            default => null
        };
    }
}

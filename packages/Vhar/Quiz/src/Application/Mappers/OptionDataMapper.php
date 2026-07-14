<?php

namespace Vhar\Quiz\Application\Mappers;

use BackedEnum;
use Illuminate\Database\Eloquent\Model;
use Vhar\Quiz\Application\Data\OptionData;

final class OptionDataMapper
{
    public function fromEnum(BackedEnum $enum): OptionData
    {
        return new OptionData(
            value: $enum->value,
            label: method_exists($enum, 'readableOption')
            ? $enum->readableOption()
            : (string) $enum->value,
        );
    }

    public function fromModel(
        Model $model,
        string $valueField = 'id',
        string $labelField = 'name',
    ): OptionData {
        return new OptionData(
            value: $model->{$valueField},
            label: $model->{$labelField},
        );
    }
}
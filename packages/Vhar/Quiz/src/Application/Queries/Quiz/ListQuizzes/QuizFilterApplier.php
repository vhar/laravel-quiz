<?php

namespace Vhar\Quiz\Application\Queries\Quiz\ListQuizzes;

use Illuminate\Database\Eloquent\Builder;
use Vhar\Quiz\Enums\QuizAvailabilityEnum;
use Vhar\Quiz\Enums\QuizStatusEnum;

final class QuizFilterApplier
{
    public function apply(
        Builder $builder,
        QuizFilters $filters,
    ): Builder {

        $builder
            ->when(
                $filters->quizTypes,
                fn(Builder $q) =>
                $q->whereIn(
                    'quiz_type',
                    $filters->quizTypes
                )
            )
            ->when(
                $filters->ageRestrictions,
                fn(Builder $q) =>
                $q->whereIn(
                    'age_restriction',
                    $filters->ageRestrictions
                )
            )
            ->when(
                $filters->durationRangeIds,
                fn(Builder $q) =>
                $q->whereIn(
                    'quiz_duration_range_id',
                    $filters->durationRangeIds
                )
            );

        if ($filters->hasTimeLimit !== null) {
            $filters->hasTimeLimit
                ? $builder->whereNotNull('time_limit')
                : $builder->whereNull('time_limit');
        }

        if ($filters->hasAttemptLimit !== null) {
            $filters->hasAttemptLimit
                ? $builder->whereNotNull('attempt_limit')
                : $builder->whereNull('attempt_limit');
        }

        if ($filters->tagIds) {
            $builder->whereHas(
                'tags',
                fn(Builder $q) =>
                $q->whereIn('tags.id', $filters->tagIds)
            );
        }

        if ($filters->availability !== null) {
            match ($filters->availability) {
                QuizAvailabilityEnum::AVAILABLE =>
                $builder->where(
                    'status',
                    QuizStatusEnum::PUBLISHED
                ),

                QuizAvailabilityEnum::FINISHED =>
                $builder->where(
                    'status',
                    QuizStatusEnum::FINISHED
                ),
            };
        }

        return $builder;
    }
}
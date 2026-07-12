<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vhar\LaravelFiles\Traits\HasFiles;
use Vhar\LaravelVideos\Traits\HasVideos;
use Vhar\Quiz\Enums\QuizAgeRestrictionEnum;
use Vhar\Quiz\Enums\QuizScoringTypeEnum;
use Vhar\Quiz\Enums\QuizStatusEnum;
use Vhar\Quiz\Enums\QuizTypeEnum;


/**
 * Class Quiz
 *
 * @property int $id
 * @property string $slug
 * @property QuizStatusEnum $status
 * @property string $title
 * @property string|null $description
 * @property int|null $user_id
 * @property QuizTypeEnum $quiz_type
 * @property int|null $quiz_duration_range_id
 * @property QuizAgeRestrictionEnum $age_restriction
 * @property int $attempt_limit
 * @property int|null $time_limit
 * @property QuizScoringTypeEnum|null $scoring_type
 * @property bool|null $change_answer
 * @property array|null $quiz_settings
 */
/** 
 * Cached number of completed attempts.
 * Updated when user completes quiz.
 * @property int $passed
 */

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Vhar\LaravelVideos\Models\Video> $videos 
 */

class Quiz extends Model
{
    use HasFiles;
    use HasVideos;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'description',
        'user_id',
        'quiz_type',
        'quiz_duration_range_id',
        'age_restriction',
        'attempt_limit',
        'time_limit',
        'scoring_type',
        'change_answer',
        'quiz_settings',
    ];

    protected $casts = [
        'status' => QuizStatusEnum::class,
        'quiz_type' => QuizTypeEnum::class,
        'age_restriction' => QuizAgeRestrictionEnum::class,
        'scoring_type' => QuizScoringTypeEnum::class,
        'change_answer' => 'boolean',
        'quiz_settings' => 'array',
    ];

    /**
     * Duration range relation.
     */
    public function durationRange(): BelongsTo
    {
        return $this->belongsTo(QuizDurationRange::class);
    }

    /**
     * Questions relation.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class)
            ->orderBy('number');
    }

    /**
     * Diagnostic keys relation.
     */
    public function diagnosticKeys(): HasMany
    {
        return $this->hasMany(QuizDiagnosticKey::class)
            ->orderBy('sort');
    }

    /**
     * Result levels relation.
     */
    public function resultLevels(): HasMany
    {
        return $this->hasMany(QuizResultLevel::class)
            ->orderBy('min_value');
    }
}
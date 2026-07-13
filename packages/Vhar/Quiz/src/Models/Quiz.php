<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vhar\LaravelFiles\Models\File;
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
 * @property int $user_id
 * @property string $title
 * @property string $slug
 * @property string|null $description
 * @property string $status
 * @property \Carbon\Carbon|null $published_at
 * @property int|null $quiz_duration_range_id
 * @property string|null $age_restriction
 * @property int|null $attempt_limit
 * @property int|null $time_limit
 * @property bool|null $change_answer
 * @property string|null $scoring_type
 * Cached number of completed attempts.
 * Updated when user completes quiz.
 * @property array|null $quiz_settings
 * @property int $passed
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 *
 * @property-read \Illuminate\Contracts\Auth\Authenticatable|null $user
 * @property-read QuizDurationRange|null $durationRange
 * @property-read Collection<int, File> $files
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
        'change_answer',
        'scoring_type',
        'quiz_settings',
    ];

    protected $casts = [
        'status' => QuizStatusEnum::class,
        'quiz_type' => QuizTypeEnum::class,
        'age_restriction' => QuizAgeRestrictionEnum::class,
        'scoring_type' => QuizScoringTypeEnum::class,
        'change_answer' => 'boolean',
        'quiz_settings' => 'array',
        'passed' => 'integer',
        'published_at' => 'datetime',
    ];

    /**
     * Duration range relation.
     */
    public function durationRange(): BelongsTo
    {
        return $this->belongsTo(QuizDurationRange::class, 'quiz_duration_range_id');
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            config('auth.providers.users.model')
        );
    }
}
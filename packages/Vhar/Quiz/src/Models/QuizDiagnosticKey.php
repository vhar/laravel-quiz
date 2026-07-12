<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vhar\LaravelFiles\Traits\HasFiles;

/**
 * Class QuizDiagnosticKey
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $name
 * @property string $description
 * @property int $sort
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 */
class QuizDiagnosticKey extends Model
{
    use HasFiles;

    protected $fillable = [
        'quiz_id',
        'name',
        'description',
        'sort',
    ];

    /**
     * Quiz relation.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Levels relation.
     */
    public function levels(): HasMany
    {
        return $this->hasMany(QuizDiagnosticKeyLevel::class)
            ->orderBy('min_value');
    }

    /**
     * Answers relation.
     */
    public function answers(): BelongsToMany
    {
        return $this->belongsToMany(
            QuizQuestionAnswer::class,
            'quiz_question_answer_diagnostic_key'
        )
            ->withPivot('value');
    }
}
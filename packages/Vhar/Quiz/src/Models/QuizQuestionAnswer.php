<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Vhar\LaravelFiles\Traits\HasFiles;
use Vhar\LaravelVideos\Traits\HasVideos;

/**
 * Class QuizQuestionAnswer
 *
 * @property int $id
 * @property int $quiz_question_id
 * @property int $number
 * @property string $title
 * @property float $score_multiplier
 * @property bool $is_true
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Vhar\LaravelVideos\Models\Video> $videos 
 */
class QuizQuestionAnswer extends Model
{
    use HasFiles;
    use HasVideos;

    protected $fillable = [
        'quiz_question_id',
        'number',
        'title',
        'score_multiplier',
        'is_true',
    ];

    protected $casts = [
        'score_multiplier' => 'decimal:2',
        'is_true' => 'boolean',
    ];

    /**
     * Question relation.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(QuizQuestion::class);
    }

    /**
     * Diagnostic keys relation.
     */
    public function diagnosticKeys(): BelongsToMany
    {
        return $this->belongsToMany(
            QuizDiagnosticKey::class,
            'quiz_question_answer_diagnostic_key'
        )
            ->withPivot('value');
    }
}
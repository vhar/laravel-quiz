<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vhar\LaravelFiles\Traits\HasFiles;
use Vhar\LaravelVideos\Traits\HasVideos;


/**
 * Class QuizQuestion
 *
 * @property int $id
 * @property int $quiz_id
 * @property int $number
 * @property string $title
 * @property int $type
 * @property int $score
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Vhar\LaravelVideos\Models\Video> $videos 
 */
class QuizQuestion extends Model
{
    use HasFiles;
    use HasVideos;

    protected $fillable = [
        'quiz_id',
        'number',
        'title',
        'type',
        'score',
    ];

    protected $casts = [
        'type' => 'integer',
        'score' => 'integer',
    ];

    /**
     * Quiz relation.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Answers relation.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(QuizQuestionAnswer::class)
            ->orderBy('number');
    }
}
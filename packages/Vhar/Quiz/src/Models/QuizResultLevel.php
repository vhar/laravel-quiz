<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vhar\LaravelFiles\Traits\HasFiles;

/**
 * Class QuizResultLevel
 *
 * @property int $id
 * @property int $quiz_id
 * @property string $name
 * @property string $description
 * @property int $min_value
 * @property int $max_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 */
class QuizResultLevel extends Model
{
    use HasFiles;

    protected $fillable = [
        'quiz_id',
        'name',
        'description',
        'min_value',
        'max_value',
    ];

    protected $casts = [
        'min_value' => 'integer',
        'max_value' => 'integer',
    ];

    /**
     * Quiz relation.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
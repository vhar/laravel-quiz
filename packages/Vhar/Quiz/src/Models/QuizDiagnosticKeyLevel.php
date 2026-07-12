<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Vhar\LaravelFiles\Traits\HasFiles;


/**
 * Class QuizDiagnosticKeyLevel
 *
 * @property int $id
 * @property int $quiz_diagnostic_key_id
 * @property string $name
 * @property string $description
 * @property int $min_value
 * @property int $max_value
 * @property-read \Illuminate\Database\Eloquent\Collection<int,\Vhar\LaravelFiles\Models\File> $files
 */
class QuizDiagnosticKeyLevel extends Model
{
    use HasFiles;
    protected $fillable = [
        'quiz_diagnostic_key_id',
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
     * Diagnostic key relation.
     */
    public function diagnosticKey(): BelongsTo
    {
        return $this->belongsTo(QuizDiagnosticKey::class);
    }
}
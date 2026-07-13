<?php

namespace Vhar\Quiz\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Vhar\Quiz\Models\Quiz;

class QuizDurationRange extends Model
{
    protected $fillable = [
        'title',
        'sort',
    ];

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'quiz_duration_range_id');
    }
}
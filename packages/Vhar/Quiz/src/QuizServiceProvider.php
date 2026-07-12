<?php

namespace Vhar\Quiz;

use Illuminate\Support\ServiceProvider;

class QuizServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/quiz.php',
            'quiz'
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(
            __DIR__ . '/../database/migrations'
        );

        $this->loadRoutesFrom(
            __DIR__ . '/../routes/quiz.php'
        );

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/quiz.php' => config_path('quiz.php'),
            ], 'quiz-config');
        }
    }
}
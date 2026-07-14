<?php

namespace Vhar\Quiz;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Application\Policies\EditPolicyRegistry;
use Vhar\Quiz\Application\Policies\QuizEditPolicy;
use Vhar\Quiz\Models\Quiz;

class QuizServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/quiz.php',
            'quiz'
        );

        $this->app->singleton(
            EditPolicyRegistry::class,
            function ($app) {
                return new EditPolicyRegistry([
                    Quiz::class => $app->make(
                        QuizEditPolicy::class
                    ),

                ]);
            }
        );
    }

    public function boot(): void
    {
        /** @var Router $router */
        $router = $this->app->make(Router::class);

        $this->loadMigrationsFrom(
            __DIR__ . '/../database/migrations'
        );

        Route::group([
            'prefix' => config('quiz.route.prefix'),
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../routes/quiz.php');
        });

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/quiz.php' => config_path('quiz.php'),
            ], 'quiz-config');
        }

        $handler = $this->app->make(
            ExceptionHandler::class
        );

        $handler->renderable(function (AccessDeniedHttpException $exception) {
            return response()->json([
                'message' => $exception->getMessage(),
            ], Response::HTTP_FORBIDDEN);
        });

        $handler->renderable(
            function (NotFoundHttpException $exception) {
                return response()->json([
                    'message' => 'Not Found',
                ], Response::HTTP_NOT_FOUND);
            }
        );
    }
}
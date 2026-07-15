<?php

use Illuminate\Support\Facades\Route;
use Vhar\Quiz\Http\Api\V1\File\AttachFileController;
use Vhar\Quiz\Http\Api\V1\File\RemoveFileController;
use Vhar\Quiz\Http\Api\V1\File\ReplaceFileController;
use Vhar\Quiz\Http\Api\V1\Quiz\CreateQuizController;
use Vhar\Quiz\Http\Api\V1\Quiz\GetQuizController;
use Vhar\Quiz\Http\Api\V1\Quiz\ListQuizzesController;
use Vhar\Quiz\Http\Api\V1\Quiz\UpdateQuizController;
use Vhar\Quiz\Http\Api\V1\QuizQuestion\CreateQuestionController;
use Vhar\Quiz\Http\Api\V1\QuizQuestion\DeleteQuestionController;
use Vhar\Quiz\Http\Api\V1\QuizQuestion\GetQuizQuestionsController;
use Vhar\Quiz\Http\Api\V1\QuizQuestion\UpdateQuestionController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/attachments', AttachFileController::class);
    Route::delete('/attachments/{fileId}', RemoveFileController::class);
    Route::put('/attachments/{fileId}', ReplaceFileController::class);

    Route::post('/quizzes', CreateQuizController::class);
    Route::put('/quizzes/{quizId}', UpdateQuizController::class);

    Route::post('/quizzes/{quizId}/questions', CreateQuestionController::class);

    Route::put('/quizzes/{quizId}/questions/{questionId}', UpdateQuestionController::class);
    Route::delete('/quizzes/{quizId}/questions/{questionId}', DeleteQuestionController::class);
});

Route::get('/quizzes', ListQuizzesController::class);
Route::get('/quizzes/{quizSlug}', GetQuizController::class);
Route::get('/quizzes/{quizSlug}/questions', GetQuizQuestionsController::class);

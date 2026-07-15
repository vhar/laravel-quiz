<?php

namespace Vhar\Quiz\Application\Queries\QuizQuestion\GetQuizQuestion;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Vhar\Quiz\Application\Mappers\QuizQuestionViewMapper;
use Vhar\Quiz\Application\Views\QuizQuestionView;
use Vhar\Quiz\Models\Quiz;
use Vhar\Quiz\Models\QuizQuestion;

/**
 * Class GetQuizQuestionHandler
 *
 * Resolves a quiz by slug, retrieves the specific question by its sequential number,
 * and loads its assets and answers.
 */
final readonly class GetQuizQuestionHandler
{
    public function __construct(
        private QuizQuestionViewMapper $mapper,
    ) {
    }

    /**
     * Handle the query.
     *
     * @param GetQuizQuestionQuery $query
     * @return QuizQuestionView
     * @throws NotFoundHttpException
     */
    public function handle(GetQuizQuestionQuery $query): QuizQuestionView
    {
        /** @var Quiz|null $quiz */
        $quiz = Quiz::where('slug', $query->quizSlug)->first();

        if ($quiz === null) {
            throw new NotFoundHttpException('Quiz not found.');
        }

        /** @var QuizQuestion|null $question */
        $question = $quiz->questions()
            ->where('number', $query->questionNumber)
            ->with([
                'files',
                'videos',
                'answers' => function ($query) {
                    // Сортируем ответы, например, по ID или сортировочному индексу
                    $query->orderBy('id');
                }
            ])
            ->first();

        if ($question === null) {
            throw new NotFoundHttpException('Question not found.');
        }

        return $this->mapper->fromModel($question);
    }
}
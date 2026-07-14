<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Vhar\Quiz\Application\Queries\ListQuizzes\ListQuizzesHandler;
use Vhar\Quiz\Application\Queries\ListQuizzes\ListQuizzesQuery;
use Vhar\Quiz\Application\Queries\ListQuizzes\SortParser;

final readonly class ListQuizzesController
{
    /**
     * Handle quiz listing request.
     *
     * @param ListQuizzesRequest $request
     * @param ListQuizzesHandler $handler
     * @param SortParser $sortParser
     *
     * @return QuizCollection
     */
    public function __invoke(
        ListQuizzesRequest $request,
        ListQuizzesHandler $handler,
        SortParser $sortParser,
    ): QuizCollection {
        return new QuizCollection(
            $handler->handle(
                new ListQuizzesQuery(
                    filters: $request->filters(),

                    sort: $sortParser->parse(
                        $request->input('sort')
                    ),

                    user: $request->user(),

                    page: $request->integer(
                        'page',
                        1
                    ),

                    perPage: $request->integer(
                        'per_page',
                        config('quiz.list.per_page')
                    ),
                )
            )
        );
    }
}
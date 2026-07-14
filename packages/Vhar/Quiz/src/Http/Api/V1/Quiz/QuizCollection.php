<?php

namespace Vhar\Quiz\Http\Api\V1\Quiz;

use Illuminate\Http\Resources\Json\ResourceCollection;

final class QuizCollection extends ResourceCollection
{
    public $collects = QuizResource::class;
}
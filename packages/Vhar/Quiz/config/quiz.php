<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Quiz List
    |--------------------------------------------------------------------------
    |
    | Settings for quiz collections and pagination.
    |
    */
    'list' => [

        // Number of quizzes displayed per page by default.
        'per_page' => 9,

    ],


    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Route settings registered by the Quiz package.
    |
    */
    'route' => [

        // Prefix applied to all package API routes.
        'prefix' => 'api/v1',

    ],


    /*
    |--------------------------------------------------------------------------
    | Author
    |--------------------------------------------------------------------------
    |
    | Settings used to build quiz author information.
    |
    */
    'author' => [

        /*
         | Attribute path used to get author display name.
         |
         | Examples:
         | - name
         | - profile.name
         | - display_name
         */
        'name_attribute' => 'name',

    ],
    /*
    |--------------------------------------------------------------------------
    | Fileable models
    |--------------------------------------------------------------------------
    |
    | Mapping between API model aliases and Eloquent models that support
    | file attachments.
    |
    | Aliases are used in API requests instead of exposing full model
    | class names to clients.
    |
    */
    'fileable_models' => [
        'quiz' => \Vhar\Quiz\Models\Quiz::class,
        'question' => \Vhar\Quiz\Models\QuizQuestion::class,
        'answer' => \Vhar\Quiz\Models\QuizQuestionAnswer::class,
        'diagnostic_key' => \Vhar\Quiz\Models\QuizDiagnosticKey::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Edit policies mapping
    |--------------------------------------------------------------------------
    |
    | Defines authorization policies used for checking whether the current
    | user can edit specific application models.
    |
    | The model class is used as a key, and the corresponding policy class
    | is resolved from the container.
    |
    | This allows adding new editable entities without changing the
    | authorization resolver implementation.
    |
    */
    'edit_policies' => [
        \Vhar\Quiz\Models\Quiz::class => \Vhar\Quiz\Application\Policies\QuizEditPolicy::class,
        \Vhar\Quiz\Models\QuizQuestion::class => \Vhar\Quiz\Application\Policies\QuizQuestionEditPolicy::class,
        \Vhar\Quiz\Models\QuizDiagnosticKey::class => \Vhar\Quiz\Application\Policies\QuizDiagnosticKeyEditPolicy::class,
    ],
];
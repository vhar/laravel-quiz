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

];
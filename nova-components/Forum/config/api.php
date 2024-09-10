<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Enable/disable
    |--------------------------------------------------------------------------
    |
    | Set to false if you want to effectively disable the API.
    |
    */

    'enable' => true,

    /*
    |--------------------------------------------------------------------------
    | Enable/disable search
    |--------------------------------------------------------------------------
    |
    | Whether or not to enable the post search endpoint.
    |
    */

    'enable_search' => true,

    /*
    |--------------------------------------------------------------------------
    | Resources
    |--------------------------------------------------------------------------
    |
    | Override to return your own resources for API responses
    |
    */

    'resources' => [
        'category' => Acme\Forum\Http\Resources\CategoryResource::class,
        'thread' => Acme\Forum\Http\Resources\ThreadResource::class,
        'post' => Acme\Forum\Http\Resources\PostResource::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Router
    |--------------------------------------------------------------------------
    |
    | API router config.
    |
    */

    'router' => [
        'prefix' => '/forum/api',
        'as' => 'forum.api.',
        'namespace' => '\Acme\Forum\Http\Controllers\Api',
        'middleware' => ['auth'],
        'auth_middleware' => ['auth'],
    ],

];

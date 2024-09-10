<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Policies
    |--------------------------------------------------------------------------
    |
    | Here we specify the policy classes to use. Change these if you want to
    | extend the provided classes and use your own instead.
    |
    */

    'policies' => [
        'forum' => Acme\Forum\Policies\ForumPolicy::class,
        'model' => [
            Acme\Forum\Models\Category::class => Acme\Forum\Policies\CategoryPolicy::class,
            Acme\Forum\Models\Thread::class => Acme\Forum\Policies\ThreadPolicy::class,
            Acme\Forum\Models\Post::class => Acme\Forum\Policies\PostPolicy::class,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Application user model
    |--------------------------------------------------------------------------
    |
    | Your application's user model.
    |
    */

    'user_model' => App\Models\User::class,

    /*
    |--------------------------------------------------------------------------
    | Application user name
    |--------------------------------------------------------------------------
    |
    | The user model attribute to use for displaying usernames.
    |
    */

    'user_name' => 'name',

];

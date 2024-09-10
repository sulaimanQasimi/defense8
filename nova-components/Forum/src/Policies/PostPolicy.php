<?php

namespace Acme\Forum\Policies;

use Acme\Forum\Models\Post;

class PostPolicy
{
    public function edit($user, Post $post): bool
    {
        return $user->hasRole("super-admin");
    }

    public function delete($user, Post $post): bool
    {
        return $user->hasRole("super-admin");
    }

    public function restore($user, Post $post): bool
    {
        return $user->hasRole("super-admin");
    }
}

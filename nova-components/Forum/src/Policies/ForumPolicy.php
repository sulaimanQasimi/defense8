<?php

namespace Acme\Forum\Policies;

class ForumPolicy
{
    public function createCategories($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function manageCategories($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function moveCategories($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function renameCategories($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function markThreadsAsRead($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function viewTrashedThreads($user): bool
    {
        return $user->hasRole("super-admin");
    }

    public function viewTrashedPosts($user): bool
    {
        return $user->hasRole("super-admin");
    }
}

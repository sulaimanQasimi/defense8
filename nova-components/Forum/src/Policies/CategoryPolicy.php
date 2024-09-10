<?php

namespace Acme\Forum\Policies;

use Acme\Forum\Models\Category;

class CategoryPolicy
{
    public function createThreads($user, Category $category): bool
    {
        return true;
    }

    public function manageThreads($user, Category $category): bool
    {
        return $user->hasRole("super-admin");
    }

    public function deleteThreads($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function restoreThreads($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function enableThreads($user, Category $category): bool
    {
        return false;
    }

    public function moveThreadsFrom($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function moveThreadsTo($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function lockThreads($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function pinThreads($user, Category $category): bool
    {
        return $user->hasRole("super-admin");
    }

    public function markThreadsAsRead($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function view($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }

    public function delete($user, Category $category): bool
    {

        return $user->hasRole("super-admin");
    }
}

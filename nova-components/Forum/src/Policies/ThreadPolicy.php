<?php

namespace Acme\Forum\Policies;

use Acme\Forum\Models\Thread;

class ThreadPolicy
{
    public function view($user, Thread $thread): bool
    {
        return true;
    }

    public function deletePosts($user, Thread $thread): bool
    {
        return $user->hasRole("super-admin");
    }

    public function restorePosts($user, Thread $thread): bool
    {
        return $user->hasRole("super-admin");
    }

    public function rename($user, Thread $thread): bool
    {
        return $user->hasRole("super-admin");
    }

    public function reply($user, Thread $thread): bool
    {
        return ! $thread->locked;
    }

    public function delete($user, Thread $thread): bool
    {
        return $user->hasRole("super-admin");
    }

    public function restore($user, Thread $thread): bool
    {
        return $user->hasRole("super-admin");
    }
}

<?php

namespace Sq\Card\Policies;

use Sq\Card\Models\PrintCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class PrintCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PrintCard $printCard): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PrintCard $printCard): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PrintCard $printCard): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PrintCard $printCard): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PrintCard $printCard): bool
    {
        return false;
    }
}

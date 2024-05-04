<?php

namespace App\Policies;

use App\Models\Card\GunCard;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class GunCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Gun Card"));

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Gun Card"));

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Gun Card"));

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Gun Card"));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Gun Card"));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Gun Card"));

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Gun Card"));

    }
}

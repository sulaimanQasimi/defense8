<?php

namespace App\Policies;

use App\Models\Card\BlackMirrorVehicalCard;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class BlackMirrorVehicalCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, BlackMirrorVehicalCard $blackMirrorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BlackMirrorVehicalCard $blackMirrorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, BlackMirrorVehicalCard $blackMirrorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, BlackMirrorVehicalCard $blackMirrorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Black Mirror Vehical Card"));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, BlackMirrorVehicalCard $blackMirrorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Black Mirror Vehical Card"));
    }
}

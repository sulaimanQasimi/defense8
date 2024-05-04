<?php

namespace App\Policies;

use App\Models\GuestOption;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class GuestOptionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Guest Option"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GuestOption $guestOption): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Guest Option"));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Guest Option"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, GuestOption $guestOption): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Guest Option"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GuestOption $guestOption): bool
    {
        return false;
        //    return $user->hasPermissionTo(PermissionTranslation::delete("Guest Option"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GuestOption $guestOption): bool
    {
        return false;

        //  return $user->hasPermissionTo(PermissionTranslation::restore("Guest Option"));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GuestOption $guestOption): bool
    {
        return false;

        // return $user->hasPermissionTo(PermissionTranslation::destroy("Guest Option"));
    }
}

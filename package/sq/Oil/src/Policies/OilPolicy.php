<?php

namespace Sq\Oil\Policies;

use Sq\Oil\Models\Oil;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class OilPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Oil"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Oil $oil): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Oil"));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::create("Oil"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Oil $oil): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Oil $oil): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Oil $oil): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Oil $oil): bool
    {
        return false;
    }
}

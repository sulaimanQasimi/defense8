<?php

namespace App\Policies;

use App\Models\Gate;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class GatePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::viewAny("Gate"));

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Gate $gate): bool
    {


        return $user->hasPermissionTo(PermissionTranslation::view("Gate"));

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::create("Gate"));

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Gate $gate): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::update("Gate"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Gate $gate): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Gate"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Gate $gate): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore("Gate"));

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Gate $gate): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Gate"));

    }
}

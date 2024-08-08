<?php

namespace Sq\Oil\Policies;

use App\Support\Defense\PermissionTranslation;
use Sq\Oil\Models\OilQuality;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class OilQualityPolicy
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
    public function view(User $user, OilQuality $oilQuality): bool
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
    public function update(User $user, OilQuality $oilQuality): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, OilQuality $oilQuality): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, OilQuality $oilQuality): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, OilQuality $oilQuality): bool
    {
        return false;
    }
}

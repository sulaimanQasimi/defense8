<?php

namespace Sq\Employee\Policies;

use App\Support\Defense\PermissionTranslation;
use Sq\Employee\Models\ScanedEmployee;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ScanedEmployeePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Card Info"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ScanedEmployee $scanedEmployee): bool
    {
        return false;
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
    public function update(User $user, ScanedEmployee $scanedEmployee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ScanedEmployee $scanedEmployee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ScanedEmployee $scanedEmployee): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ScanedEmployee $scanedEmployee): bool
    {
        return false;
    }
}

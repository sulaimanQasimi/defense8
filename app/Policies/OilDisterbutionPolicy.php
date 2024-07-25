<?php

namespace App\Policies;

use App\Models\OilDisterbution;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class OilDisterbutionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::viewAny("Oil"));
    }
    public function view(User $user, OilDisterbution $oilDisterbution): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;

    }
    public function update(User $user, OilDisterbution $oilDisterbution): bool
    {
        return false;
    }
    public function delete(User $user, OilDisterbution $oilDisterbution): bool
    {
        return false;
    }
    public function restore(User $user, OilDisterbution $oilDisterbution): bool
    {
        return false;
    }
    public function forceDelete(User $user, OilDisterbution $oilDisterbution): bool
    {
        return false;
    }
}

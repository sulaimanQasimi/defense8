<?php

namespace Sq\Oil\Policies;

use App\Models\User;
use Sq\Oil\Models\PumpStation;

class PumpStationPolicy
{
    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('viewAny-pump-station');
    }

    public function view(User $user, PumpStation $pumpStation)
    {
        return $user->hasPermissionTo('view-pump-station');
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create-pump-station');
    }

    public function update(User $user, PumpStation $pumpStation)
    {
        return $user->hasPermissionTo('update-pump-station');
    }

    public function delete(User $user, PumpStation $pumpStation)
    {
        return $user->hasPermissionTo('delete-pump-station');
    }

    public function restore(User $user, PumpStation $pumpStation)
    {
        return $user->hasPermissionTo('restore-pump-station');
    }

    public function forceDelete(User $user, PumpStation $pumpStation)
    {
        return $user->hasPermissionTo('destroy-pump-station');
    }
}

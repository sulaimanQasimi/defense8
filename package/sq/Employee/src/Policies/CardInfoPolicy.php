<?php

namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;;
use Sq\Employee\Models\CardInfo;
use Sq\Employee\Models\Gate;
use Sq\Query\Policy\UserDepartment;

class CardInfoPolicy
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
    public function view(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Card Info")) && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Card Info"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Card Info")) && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Card Info")) && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Card Info")) && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Card Info")) && in_array($infoCard->orginization->id, UserDepartment::getUserDepartment());
    }

    public function attachAnyGate(): bool
    {
        return false;
    }
    public function detachGate(User $user, CardInfo $cardInfo, Gate $gate)
    {
        return false;
    }

    public function gatePass(User $user, CardInfo $infoCard): bool
    {
        // return ($user->gate && $infoCard->gate) ? $user?->gate->id == $infoCard?->gate->id : false;
        if ($user->gate && $infoCard->gate) {

            if ($user?->gate->id == $infoCard?->gate->id) {
                return true;
            }

            if (in_array($infoCard?->gate->id,UserDepartment::getUserGate())) {
                return true;
            }
        }





        return false;

    }
}

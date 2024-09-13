<?php

namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\GunCard;
use Sq\Query\Policy\UserDepartment;

class GunCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Gun Card")) ;

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Gun Card"))  && in_array($gunCard->card_info->orginization->id, UserDepartment::getUserDepartment());

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
        return $user->hasPermissionTo(PermissionTranslation::update("Gun Card"))  && in_array($gunCard->card_info->orginization->id, UserDepartment::getUserDepartment());

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Gun Card"))  && in_array($gunCard->card_info->orginization->id, UserDepartment::getUserDepartment());

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Gun Card"))  && in_array($gunCard->card_info->orginization->id, UserDepartment::getUserDepartment());

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, GunCard $gunCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Gun Card"))  && in_array($gunCard->card_info->orginization->id, UserDepartment::getUserDepartment());

    }
}

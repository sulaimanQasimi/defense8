<?php

namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\MainCard;
use Sq\Query\Policy\UserDepartment;

class MainCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Main Card"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MainCard $mainCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Main Card")) && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Main Card"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MainCard $mainCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Main Card")) && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MainCard $mainCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Main Card")) && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) && (!$mainCard->printed);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MainCard $mainCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Main Card")) && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) && (!$mainCard->printed);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MainCard $mainCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Main Card")) && in_array($mainCard->card_info->orginization->id, UserDepartment::getUserDepartment()) && (!$mainCard->printed);
    }
}

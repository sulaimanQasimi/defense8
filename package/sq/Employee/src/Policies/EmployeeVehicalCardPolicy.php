<?php


namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\EmployeeVehicalCard;
use Sq\Query\Policy\UserDepartment;

class EmployeeVehicalCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Employee Vehical Card"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmployeeVehicalCard $employeeVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Employee Vehical Card")) && in_array($employeeVehicalCard->card_info->orginization->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Employee Vehical Card")) ;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmployeeVehicalCard $employeeVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Employee Vehical Card")) && in_array($employeeVehicalCard->card_info->orginization->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmployeeVehicalCard $employeeVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Employee Vehical Card")) && in_array($employeeVehicalCard->card_info->orginization->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmployeeVehicalCard $employeeVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Employee Vehical Card")) && in_array($employeeVehicalCard->card_info->orginization->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmployeeVehicalCard $employeeVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Employee Vehical Card")) && in_array($employeeVehicalCard->card_info->orginization->id,  UserDepartment::getUserDepartment());
    }
}

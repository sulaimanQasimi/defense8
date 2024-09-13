<?php


namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\Gate;
use Sq\Query\Policy\UserDepartment;

class GatePolicy
{
    public $resource = "Gate";

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::viewAny($this->resource));

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Gate $gate): bool
    {


        return $user->hasPermissionTo(PermissionTranslation::view($this->resource)) && in_array($gate->department->id,  UserDepartment::getUserDepartment());

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::create($this->resource)) ;

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Gate $gate): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::update($this->resource)) && in_array($gate->department->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Gate $gate): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete($this->resource)) && in_array($gate->department->id,  UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Gate $gate): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore($this->resource)) && in_array($gate->department->id,  UserDepartment::getUserDepartment());

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Gate $gate): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy($this->resource)) && in_array($gate->department->id,  UserDepartment::getUserDepartment());

    }
    public function gateChecker(User $user): bool
    {
        return $user->hasPermissionTo("Gate Checker");
    }
    public function gateCheckerOwnDepartment(User $user, Gate $gate): bool
    {
        return $user->hasPermissionTo("Gate Checker")  && $user?->department->id === $gate->department->id ;
    }


}

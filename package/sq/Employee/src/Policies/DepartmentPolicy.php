<?php

namespace Sq\Employee\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Employee\Models\Department;

class DepartmentPolicy
{

    public $resource="Department";
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
    public function view(User $user, Department $department): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::view($this->resource));

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create($this->resource));


    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update($this->resource));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete($this->resource));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, department $department): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore($this->resource));

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy($this->resource));

    }
    public function admin(User $user, department $department): bool
    {
        return ($user->department)?$user->department->id===$department->id:false;

    }
}

<?php

namespace App\Policies;

use App\Models\User;
use App\Models\department;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
{

    public $perModel="Department";
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny($this->perModel));

    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, department $department): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::view($this->perModel));

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create($this->perModel));


    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update($this->perModel));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete($this->perModel));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, department $department): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore($this->perModel));

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, department $department): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy($this->perModel));

    }
    public function admin(User $user, department $department): bool
    {
        return $user->id===$department->user_id;

    }
}

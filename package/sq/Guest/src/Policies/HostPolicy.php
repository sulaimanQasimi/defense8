<?php

namespace Sq\Guest\Policies;

use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;
use Sq\Guest\Models\Host;
use Sq\Query\Policy\UserDepartment;

class HostPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    protected function owner(User $user,Host $host) {
        if($user->host){
            return $user->host->id === $host->id;
        }
        return true;


    }
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Host"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Host $host): bool
    {
        return
        $user->hasPermissionTo(PermissionTranslation::view("Host")) && $this->owner($user,$host) && in_array($host->deparment_id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Host"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Host $host): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Host"))
        && $this->owner($user,$host) && in_array($host->deparment_id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Host $host): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Host"))
        && $this->owner($user,$host) && in_array($host->deparment_id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can restorPermissionTranslation::viewAny("Host")
     */
    public function restore(User $user, Host $host): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Host"))
        && $this->owner($user,$host) && in_array($host->deparment_id, UserDepartment::getUserDepartment());
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Host $host): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Host"));
    }
}

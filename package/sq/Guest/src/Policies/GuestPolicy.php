<?php

namespace Sq\Guest\Policies;

use Sq\Employee\Models\Gate;
use Sq\Guest\Models\Guest;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Carbon\Carbon;
use Illuminate\Auth\Access\Response;

class GuestPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Guest")) || \Illuminate\Support\Facades\Gate::allows('gateChecker', Gate::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Guest $guest): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Guest"));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Guest")) && $user->host;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Guest $guest): bool
    {
        $date = Carbon::make($guest->registered_at);
        return $user->hasPermissionTo(PermissionTranslation::update("Guest")) && $user->id === $guest->host->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Guest $guest): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Guest")) && $user->id === $guest->host->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Guest $guest): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore("Guest")) && $user->id === $guest->host->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Guest $guest): bool
    {
        return false;
    }
    public function attachAnyGate(): bool
    {

        if (auth()->user()->host) {
            return false;
        }

        if (auth()->user()->gate) {
//            return true;
        }

        return false;
    }
    public function detachGate(User $user, Guest $guest, Gate $gate)
    {
        return false;
    }
    public function generate(User $user,Guest $guest): bool
    {
        return $user->id === $guest->host->user_id || \Illuminate\Support\Facades\Gate::allows('gateChecker', Gate::class);
    }

}

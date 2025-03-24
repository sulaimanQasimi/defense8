<?php

namespace Sq\Guest\Policies;

use Sq\Employee\Models\Gate;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Sq\Guest\Models\Patient;

class PatientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Patient")) || \Illuminate\Support\Facades\Gate::allows('gateChecker', Gate::class);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Patient $patient): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Patient")) && $user->id === $patient->host->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Patient")) && $user->host;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Patient $patient): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Patient")) && $user->id === $patient->host->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Patient")) && $user->id === $patient->host->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Patient $patient): bool
    {

        return $user->hasPermissionTo(PermissionTranslation::restore("Patient")) && $user->id === $patient->host->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Patient $patient): bool
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
    public function detachGate(User $user, Patient $patient, Gate $gate)
    {
        return false;
    }
    public function generate(User $user,Patient $patient): bool
    {
        return $user->id === $patient->host->user_id || \Illuminate\Support\Facades\Gate::allows('gateChecker', Gate::class);
    }
}

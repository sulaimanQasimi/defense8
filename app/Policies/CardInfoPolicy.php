<?php

namespace App\Policies;

use App\Models\Card\CardInfo;
use App\Models\Gate;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

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
        return $user->hasPermissionTo(PermissionTranslation::view("Card Info"));
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
        return $user->hasPermissionTo(PermissionTranslation::update("Card Info"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Card Info"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Card Info"));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CardInfo $infoCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Card Info"));
    }

    public function attachAnyGate(): bool
    {
        return false;
    }
    public function detachGate(User $user, CardInfo $cardInfo, Gate $gate)
    {
        return false;
    }
}

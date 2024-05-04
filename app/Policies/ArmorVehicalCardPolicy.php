<?php

namespace App\Policies;

use App\Models\Card\ArmorVehicalCard;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class ArmorVehicalCardPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::viewAny("Armor Vehical Card"));
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ArmorVehicalCard $armorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Armor Vehical Card"));

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Armor Vehical Card"));

    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ArmorVehicalCard $armorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Armor Vehical Card"));

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ArmorVehicalCard $armorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Armor Vehical Card"));

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ArmorVehicalCard $armorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Armor Vehical Card"));

    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ArmorVehicalCard $armorVehicalCard): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Armor Vehical Card"));

    }
}

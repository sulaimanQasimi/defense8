<?php

namespace Sq\Card\Policies;

use Sq\Card\Models\PrintCardFrame;
use App\Models\User;
use App\Support\Defense\PermissionTranslation;
use Illuminate\Auth\Access\Response;

class PrintCardFramePolicy
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
    public function view(User $user, PrintCardFrame $printCardFrame): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::view("Card Info"));
    }
    public function create(User $user): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::create("Card Info"));
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PrintCardFrame $printCardFrame): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::update("Card Info"));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PrintCardFrame $printCardFrame): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::delete("Card Info"));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PrintCardFrame $printCardFrame): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::restore("Card Info"));
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PrintCardFrame $printCardFrame): bool
    {
        return $user->hasPermissionTo(PermissionTranslation::destroy("Card Info"));
    }
}

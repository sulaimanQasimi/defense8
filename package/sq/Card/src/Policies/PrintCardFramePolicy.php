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
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, PrintCardFrame $printCardFrame): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }
    public function create(User $user): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, PrintCardFrame $printCardFrame): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, PrintCardFrame $printCardFrame): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, PrintCardFrame $printCardFrame): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, PrintCardFrame $printCardFrame): bool
    {
        return false;
    }
}

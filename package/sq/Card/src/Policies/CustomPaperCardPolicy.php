<?php

namespace Sq\Card\Policies;

use Sq\Card\Models\CustomPaperCard;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CustomPaperCardPolicy
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
    public function view(User $user, CustomPaperCard $customPaperCard): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, CustomPaperCard $customPaperCard): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CustomPaperCard $customPaperCard): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CustomPaperCard $customPaperCard): bool
    {
        return auth()->user()->hasPermissionTo("design-card");
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CustomPaperCard $customPaperCard): bool
    {
        return false;
    }
}

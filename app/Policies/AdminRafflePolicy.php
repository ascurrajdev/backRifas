<?php

namespace App\Policies;

use App\Models\AdminRaffle;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AdminRafflePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->tokenCan("list_admin_raffle");
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, AdminRaffle $adminRaffle): bool
    {

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->tokenCan("create_admin_raffle");
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, AdminRaffle $adminRaffle): bool
    {
        
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, AdminRaffle $adminRaffle): bool
    {
        
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, AdminRaffle $adminRaffle): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, AdminRaffle $adminRaffle): bool
    {
        //
    }
}

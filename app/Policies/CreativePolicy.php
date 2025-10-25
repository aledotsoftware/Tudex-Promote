<?php

namespace App\Policies;

use App\Models\Creative;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CreativePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'advertiser';
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Creative $creative): bool
    {
        return $user->id === $creative->campaign->advertiser_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'advertiser';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Creative $creative): bool
    {
        return $user->id === $creative->campaign->advertiser_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Creative $creative): bool
    {
        return $user->id === $creative->campaign->advertiser_id;
    }
}

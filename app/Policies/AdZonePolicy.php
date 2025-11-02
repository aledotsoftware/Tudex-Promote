<?php

namespace App\Policies;

use App\Models\AdZone;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdZonePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdZone  $adZone
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, AdZone $adZone)
    {
        return $user->id === $adZone->site->user_id;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return $user->role === 'publisher';
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdZone  $adZone
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, AdZone $adZone)
    {
        return $user->id === $adZone->site->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\AdZone  $adZone
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, AdZone $adZone)
    {
        return $user->id === $adZone->site->user_id;
    }
}

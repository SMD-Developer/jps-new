<?php

namespace App\Policies;

use App\Models\User;

class ProfilePolicy
{

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        return hasPermission('profile.view');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        return hasPermission('profile.edit');
    }
}

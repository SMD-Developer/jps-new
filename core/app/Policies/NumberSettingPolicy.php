<?php

namespace App\Policies;

use App\Models\NumberSetting;
use App\Models\User;

class NumberSettingPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NumberSetting $numberSetting): bool
    {
        return hasPermission('number-settings.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('number-settings.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NumberSetting $numberSetting): bool
    {
        return hasPermission('number-settings.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NumberSetting $numberSetting): bool
    {
        return hasPermission('number-settings.delete');
    }
}

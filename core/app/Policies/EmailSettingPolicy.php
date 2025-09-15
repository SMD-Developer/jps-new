<?php

namespace App\Policies;

use App\Models\EmailSetting;
use App\Models\User;

class EmailSettingPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmailSetting $emailSetting): bool
    {
        return hasPermission('email-setting.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('email-setting.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmailSetting $emailSetting): bool
    {
        return hasPermission('email-setting.edit');
    }
}

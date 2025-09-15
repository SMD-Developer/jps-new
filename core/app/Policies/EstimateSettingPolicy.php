<?php

namespace App\Policies;

use App\Models\EstimateSetting;
use App\Models\User;

class EstimateSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function view(User $user): bool
    {
        return hasPermission('estimate-setting.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('estimate-setting.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EstimateSetting $estimateSetting): bool
    {
        return hasPermission('estimate-setting.edit');
    }
}

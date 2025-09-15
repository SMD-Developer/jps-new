<?php

namespace App\Policies;

use App\Models\TaxSetting;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaxSettingPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return hasPermission('tax-setting.view-all');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TaxSetting $taxSetting): bool
    {
        return hasPermission('tax-setting.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('tax-setting.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TaxSetting $taxSetting): bool
    {
        return hasPermission('tax-setting.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TaxSetting $taxSetting): bool
    {
        return hasPermission('tax-setting.delete');
    }
}

<?php

namespace App\Policies;

use App\Models\InvoiceSetting;
use App\Models\User;

class InvoiceSettingPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, InvoiceSetting $invoiceSetting): bool
    {
        return hasPermission('invoice-setting.view');
    }
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('invoice-setting.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, InvoiceSetting $invoiceSetting): bool
    {
        return hasPermission('invoice-setting.edit');
    }
}

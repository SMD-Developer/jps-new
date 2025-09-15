<?php

namespace App\Policies;

use App\Models\Locale;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LocalePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return hasPermission('locale.view-all');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Locale $locale): bool
    {
        return hasPermission('locale.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return hasPermission('locale.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Locale $locale): bool
    {
        return hasPermission('locale.edit');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Locale $locale): bool
    {
        return hasPermission('locale.delete');
    }
}

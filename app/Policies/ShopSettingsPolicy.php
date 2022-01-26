<?php

namespace App\Policies;

use App\Models\ShopSetting;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShopSettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(User $user)
    {
        return $user->hasAnyPermission(['view_shop_settings']);
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShopSetting  $shopSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(User $user, ShopSetting $shopSetting)
    {
        return $user->hasAnyPermission(['view_shop_settings']);
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(User $user)
    {
        return false; // Shop settings cannot be created nor removed. They are defined by the system.
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShopSetting  $shopSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, ShopSetting $shopSetting)
    {
        return $user->hasAnyPermission(['update_shop_settings']);
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShopSetting  $shopSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, ShopSetting $shopSetting)
    {
        return false; // Shop settings cannot be created nor removed. They are defined by the system.
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShopSetting  $shopSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(User $user, ShopSetting $shopSetting)
    {
        return false; // Shop settings cannot be created nor removed. They are defined by the system.
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\ShopSetting  $shopSetting
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(User $user, ShopSetting $shopSetting)
    {
        return false; // Shop settings cannot be created nor removed. They are defined by the system.
    }
}

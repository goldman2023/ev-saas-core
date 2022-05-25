<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Outl1ne\MenuBuilder\Models\Menu;
use Outl1ne\MenuBuilder\MenuBuilder;

class WeMenu extends Menu
{
    // This relationship must be overridden since we use different table names (`menu_id` is the foreign key column, not `we_menu_id`)
    public function rootMenuItems()
    {
        return $this
            ->hasMany(MenuBuilder::getMenuItemClass(), 'menu_id')
            ->where('parent_id', null)
            ->orderBy('parent_id')
            ->orderBy('order')
            ->orderBy('name');
    }
}

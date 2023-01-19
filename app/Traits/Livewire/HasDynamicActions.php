<?php

namespace App\Traits\Livewire;

use Closure;

trait HasDynamicActions
{
    public function dynamicAction($action_name = null) {
        $actions_list = apply_filters('livewire.forms.dynamic-actions.list');

        if(!empty($actions_list ?? null)) {
            foreach($actions_list as $name => $action_fn) {
                if($name === $action_name && $action_fn instanceof Closure) {
                    return $action_fn($this);
                }
            }
        }
    }
}

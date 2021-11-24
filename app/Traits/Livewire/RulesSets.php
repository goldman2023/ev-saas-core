<?php

namespace App\Traits\Livewire;

trait RulesSets
{
    /**
     * If Livewire component uses this trait, it has to define(override) rules() and messages() functions.
     * @return mixed
     */
    abstract protected function rules();
    abstract protected function messages();

    protected function getRuleSet($set_name = null) {
        $all_rules = $this->getRules();

        if(empty($set_name) && !empty($this->rules)) {
            $set = [];

            foreach($all_rules as $key => $rules) {
                if(str_starts_with($set_name.'.', $key)) {
                    $set[$key] = $rules;
                }
            }

            return $set;
        }

        return $all_rules;
    }
}

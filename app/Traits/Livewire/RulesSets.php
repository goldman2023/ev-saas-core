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

    protected function getRuleSet($set_name = null)
    {
        $all_rules = $this->getRules();

        if (! empty($set_name) && ! empty($all_rules)) {
            $set = [];

            foreach ($all_rules as $key => $rules) {
                if (str_starts_with($key, $set_name.'.')) {
                    $set[$key] = $rules;
                }
            }

            return $set;
        }

        return $all_rules;
    }

    protected function getIndexedRuleSet($set_name, $index)
    {
        $rule_set = $this->getRuleSet($set_name);

        foreach ($rule_set as $key => $value) {
            $rule_set[str_replace('.*.', '.'.$index.'.', $key)] = $value;
            unset($rule_set[$key]);
        }

        return $rule_set;
    }
}

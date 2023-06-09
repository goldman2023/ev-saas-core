<?php

namespace App\Traits\Livewire;

use Illuminate\Support\Arr;
use App\Traits\HasContentColumn;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;

trait RulesSets
{
    /**
     * If Livewire component uses this trait, it has to define(override) rules() and messages() functions.
     * @return mixed
     */
    abstract protected function rules();

    abstract protected function messages();

    protected function rulesSets() {
        return [
            'default' => []
        ];
    }

    protected function getRuleSetsCombined($data = [], $fallback_set = 'default') {
        if($data === 'all') {
            return array_reduce($this->rulesSets(), function($carry, $rules) {
                if(empty($carry)) {
                    return array_merge([], $rules);
                }

                return array_merge($carry, $rules);
            });
        }

        if(!empty($data) && is_array($data)) {
            $rules = [];

            foreach($data as $set_name => $set_condition) {
                if(is_string($set_condition) && !empty($set_condition) && !empty($this->rulesSets()[$set_condition] ?? false)) {
                    // If $set_condition is a string, then there's no condition, and we should just include set of rules with $set_condition name
                    $rules = array_merge($rules, $this->rulesSets()[$set_condition]);
                } else if(is_string($set_name) && $set_condition instanceof \Closure && $set_condition() === true) {
                    $rules = array_merge($rules, $this->rulesSets()[$set_name]);
                }
            }

            return $rules;
        }

        return ($this?->rulesSets() ?? [])['fallback_set'] ?? [];
    }

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

    protected function getMetaRuleSet($model, $set_name = null, $custom_rules = null) {
        $defaultMetaRuleSets = [
            'wef_meta' => [
                
            ],
            'core_meta' => [

            ]
        ];
        $metaRuleSets = [];

        // Set Meta Defaults
        if(class_has_trait($model::class, HasContentColumn::class)) {
            $defaultMetaRuleSets['wef_meta']['wef.'.$model::getContentStructureCoreMetaName()] = 'nullable';
        }

        // Set custom rules
        if(!empty($custom_rules) && (is_array($custom_rules) || $custom_rules instanceof Collection)) {
            if($custom_rules instanceof Collection) {
                $custom_rules = $custom_rules->toArray(); // turn collection to array!
            }

            if(empty($set_name) || $set_name === 'all') {
                $metaRuleSets = array_deep_merge($defaultMetaRuleSets, $custom_rules);
            } else {
                $metaRuleSets = array_deep_merge($defaultMetaRuleSets[$set_name], $custom_rules);
            }
        }

        return $metaRuleSets;
    }

    protected function overrideRulesBasedOnStatus($data, $model) {
        if(empty($model) || !($model instanceof Model)) {
            return [];
        }
        
        $all = [];
        $default = [];

        if(!empty($data)) {
            $default = $data['default'] ?? [];

            foreach($data as $status => $rules) {
                if($status === 'default') continue;

                if($status === $model->status) {
                    $all = array_merge($default, $rules);
                    break;
                }
            }
        }

        return empty($all) ? $default : $all;
    }
}

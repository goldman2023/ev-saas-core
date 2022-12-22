<?php

namespace App\Traits\Livewire;

use DB;
use WEF;
use App\Models\Plan;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\CoreMeta;

/**
 * Keep in mind that both core_meta and wef are actually core_meta table rows.
 * Difference between core_meta and wef is that wefs are already DEFINED core meta fields (like ACF) and we know their data type in advance because it's defined already!
 * core_meta are all other (non-wef) core_meta rows!
 * 
 * @var mixed
 */
trait HasCoreMeta
{    
    public $core_meta;
    public $wef;

    public function initCoreMeta(&$model = null)
    {
        if(!empty($model)) {
            // Init CoreMeta (non-WEF)
            $this->core_meta = collect($model->core_meta->filter(function($item) use($model) {
                // Skip WEFs
                return ! WEF::isWEF($model, $item->key);
            })->map(fn($item) => ['key' => $item->key, 'value' => $item->value])->values()->toArray());

            // Init WEF
            $this->wef = WEF::getAllMeta(model: $model, only_wef: true);
        }
    }

    protected function saveCoreMeta(&$model = null)
    {
        if (!empty($model)) {
            $old_core_meta_keys = $model->core_meta()->select('key')->get()->pluck('key');
            $missing_core_meta_keys = $old_core_meta_keys->diff(collect($this->core_meta)->pluck('key'));

            if(is_array($this->core_meta)) {
                foreach ($this->core_meta as $meta) {
                    // Skip WEF
                    if(WEF::isWEF($model, $meta['key'])) {
                        continue;
                    }

                    if(!empty($meta['key'] ?? null)) {
                        CoreMeta::updateOrCreate(
                            [
                                'key' => $meta['key'],
                                'subject_id' => $model->id,
                                'subject_type' => $model::class
                            ],
                            [
                                'value' => $meta['value']
                            ]
                        );
                    }
                }
            }


            // Delete missing core_meta
            if($missing_core_meta_keys->isNotEmpty()) {

                if(empty(WEF::getWEFDataTypes($model))) {
                    $keys_to_delete = $missing_core_meta_keys->toArray();
                } else {
                    // Skip WEF deletion
                    $keys_to_delete = array_keys(array_diff_key(array_flip($missing_core_meta_keys->toArray()), WEF::getWEFDataTypes($model)));
                }

                $model->core_meta()->whereIn('key', $keys_to_delete)->delete();
            }
        }
    }

    protected function saveWEF($model)
    {
        if (!empty($model)) {
            foreach (collect($this->getMetaRuleSet($model, 'wef_meta', $this->getWEFRules()))->filter(fn ($item, $key) => str_starts_with($key, 'wef')) as $key => $value) {
                $core_meta_key = explode('.', $key)[1]; // get the part after `wef.`
    
                if (! empty($core_meta_key) && $core_meta_key !== '*') {
                    if(array_key_exists($core_meta_key, is_array($this->wef) ? $this->wef : $this->wef->toArray())) {
                        
                        $new_value = castValueForSave($core_meta_key, $this->wef[$core_meta_key], WEF::getWEFDataTypes($model));
                        
                        try {
                            CoreMeta::updateOrCreate(
                                ['subject_id' => $model->id, 'subject_type' => $model::class, 'key' => $core_meta_key],
                                ['value' => $new_value]
                            );
                        } catch(\Exception $e) {
                            Log::error($e->getMessage());
                        }
                    }
                }
            }
        }

    }

    protected function saveAllCoreMeta($model) {
        $this->saveCoreMeta($model);
        $this->saveWEF($model);
    }

    public abstract function getWEFRules();
    public abstract function getWEFMessages();
}

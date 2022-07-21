<?php

namespace App\Traits\Livewire;

use App\Models\CoreMeta;
use App\Models\Product;
use App\Models\Plan;
use App\Models\BlogPost;
use DB;

trait HasCoreMeta
{
    public $core_meta;

    public function initCoreMeta(&$model = null)
    {
        $this->core_meta = collect($model->core_meta->filter(function($item) use($model) {
            // Skip predefined CoreMeta keys
            if($model instanceof Product && array_key_exists($item->key, CoreMeta::metaProductDataTypes())) {
                return false;
            } else if($model instanceof Plan && array_key_exists($item->key, CoreMeta::metaPlanDataTypes()) ) {
                return false;
            } else if($model instanceof BlogPost && array_key_exists($item->key, CoreMeta::metaBlogPostDataTypes()) ) {
                return false;
            }  else {
                return true;
            }
        })->map(fn($item) => ['key' => $item->key, 'value' => $item->value])->toArray());
    }

    protected function setCoreMeta(&$model = null)
    {
        if (!empty($model)) {
            $old_core_meta_keys = $model->core_meta()->select('key')->get()->pluck('key');
            $missing_core_meta_keys = $old_core_meta_keys->diff(collect($this->core_meta)->pluck('key'));

            if(is_array($this->core_meta)) {
                foreach ($this->core_meta as $meta) {
                    // Skip predefined keys for various content types
                    if($model instanceof Product && array_key_exists($meta['key'], CoreMeta::metaProductDataTypes()) ) {
                        continue;
                    } else if($model instanceof Plan && array_key_exists($meta['key'], CoreMeta::metaPlanDataTypes()) ) {
                        continue;
                    } else if($model instanceof BlogPost && array_key_exists($meta['key'], CoreMeta::metaBlogPostDataTypes()) ) {
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

                // Skip predefined keys for various content types
                if($model instanceof Product) {
                    $keys_to_delete = array_keys(array_diff_key(array_flip($missing_core_meta_keys->toArray()), CoreMeta::metaProductDataTypes()));
                } else if($model instanceof Plan) {
                    $keys_to_delete = array_keys(array_diff_key(array_flip($missing_core_meta_keys->toArray()), CoreMeta::metaPlanDataTypes()));
                } else if($model instanceof BlogPost) {
                    $keys_to_delete = array_keys(array_diff_key(array_flip($missing_core_meta_keys->toArray()), CoreMeta::metaBlogPostDataTypes()));
                } else {
                    $keys_to_delete = $missing_core_meta_keys->toArray();
                }

                $model->core_meta()->whereIn('key', $keys_to_delete)->delete();
            }
        }
    }
}

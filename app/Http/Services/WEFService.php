<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\CoreMeta;
use App\Models\UserSubscription;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;


/**
 * WEFService
 * 
 * WEFs (WeField(s)) are:
 * 1. Stored in `core_meta` table
 * 2. Depend on wef-json structure files stored for each tenant (like acf-json)
 * 3. Fallback: to basic core_meta value if no key for wef is defined in json (basically, fetches core_meta row for given key without casting to specific data type)
 * 4. Used for replacing model_core_meta and hard-coded dataTypes for various different core_meta(s)
 * 5. Are editable through CRUD form - like ACF (and each time new structure is saved, wef-json file for the wef group is saved and redis cache is cleared)
 */
class WEFService
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app;

        
    }
    
    /**
     * getWEFDataTypes
     *
     * This function gets the WeFields definitions for provided $model (actually, it's content type)
     * $model parameter can be a Model object or a model class string.
     * 
     * @param  mixed $model
     * @return mixed
     */
    public function getWEFDataTypes($model) {
        if($model instanceof Model) {
            $model = $model::class;
        }

        return match ($model) {
            Product::class => CoreMeta::metaProductDataTypes(),
            BlogPost::class => CoreMeta::metaBlogPostDataTypes(),
            Plan::class => CoreMeta::metaPlanDataTypes(),
            UserSubscription::class => CoreMeta::metaUserSubscriptionDataTypes(),
            default => [],
        };
    }
    
    /**
     * getAllMeta
     * 
     * This function gets all core meta of the certain model.
     * It can also return only WEFs if $only_wef is set to true!
     *
     * @param  mixed $model
     * @param  mixed $core_meta
     * @param  mixed $content_type
     * @param  mixed $only_wef
     * @return mixed
     */
    public function getAllMeta($model = null, $core_meta = null, $content_type = null, $only_wef = false)
    {
        if(!empty($model)) {
            $core_meta = $model->core_meta;
            $content_type = $model::class;
        } else if(empty($core_meta)) {
            return [];
        }

        if (is_array($core_meta)) {
            if (empty($core_meta)) {
                $core_meta = [];
            } else {
                $core_meta = collect($core_meta)->keyBy('key')->toArray();
            }
        } else {
            $core_meta = $core_meta->keyBy('key')->toArray();
        }

        $data_types = $this->getWEFDataTypes($content_type);

        castValuesForGet($core_meta, $data_types);
        
        $missing = array_diff_key($data_types, $core_meta);
        $missing_clone = $missing;
        
        // TODO: Fix logic to not include value anymore or something like that!
        if (! empty($missing)) {
            foreach ($missing as $key => $type) {
                $missing[$key] = null;
            }
            castValuesForGet($missing, $missing_clone);
        }

        // If only_wef is true, get only core_meta from $data_types, remove other meta
        if($only_wef) {
            return collect(array_intersect_key(array_merge($core_meta, $missing), $data_types))->map(fn($item, $key) => $item);
        }

        return array_merge($core_meta, $missing);
    }
    
    /**
     * isWEF
     *
     * This function checks if core_meta for given key is actually a WEF core_meta of given $model
     * 
     * @param  mixed $model
     * @param  mixed $core_meta_key - can be CoreMeta or key as string
     * @return bool
     */
    public function isWEF($model, $core_meta_key) : bool {
        if($core_meta_key instanceof CoreMeta) {
            $core_meta_key = $core_meta_key->key;
        }

        return array_key_exists($core_meta_key, $this->getWEFDataTypes($model));
    }
}

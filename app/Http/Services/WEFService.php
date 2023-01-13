<?php

namespace App\Http\Services;

use App\Models\Plan;
use App\Models\Upload;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\CoreMeta;
use App\Traits\CoreMetaTrait;
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
     * globalWEFDataTypes
     * 
     * All global WEF DataTypes should be included here.
     *
     * @return void
     */
    public static function globalWEFDataTypes() {
        return [
            'content_structure' => 'array',
        ];
    }
    
    /**
     * bundleWithGlobalWEF
     * 
     * This function is just a wrapper to merge given $data_types with global WEF data types and return it all.
     *
     * @param  mixed $data_types
     * @return array
     */
    public static function bundleWithGlobalWEF($data_types = []) {
        if($data_types instanceof Collection) {
            $data_types = $data_types->toArray();
        }

        return array_merge(self::globalWEFDataTypes(), $data_types);
    }
    
    /**
     * getWEFDataTypes
     *
     * This function gets the WeFields definitions for provided $model (actually, it's content type)
     * $model parameter can be a Model object or a model class string.
     * 
     * Remember, this function is a staic function and needs a provided $model as a parameter to work.
     * Reason for using this function instead of just writing `$model->getWEFDataTypes()`, is that this function:
     * 1) checks if $model actually has the CoreMetaTrait which defines that $model using it must have getWEFDataTypes() defined,
     * 2) we can provide  $model as a class string, not just an object
     * 
     * If 1. is not the case, then $data_types are empty array and there's no error. 
     * But when using $model->getWEFDataTypes() directly we can encounter breaking errors!
     * 
     * So, consider this as a wrapper static function from the WEF service itself, which properly gets the model's WEF data_types
     * 
     * @param  mixed $model (can be either model instance or model class name)
     * @return mixed
     */
    public static function getWEFDataTypes($model) {
        $data_types = [];
        
        try {
            if($model instanceof Model && class_has_trait($model::class, CoreMetaTrait::class)) {
                $data_types = $model->getWEFDataTypes();
            } else if(is_string($model) && class_exists($model) && class_has_trait($model, CoreMetaTrait::class)) {
                $data_types = $this->app->make($model)->getWEFDataTypes();
            }
        } catch(\Throwable $e) {
            $data_types = [];
        }

        return $data_types;
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

        $data_types = self::getWEFDataTypes($content_type);

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

        return array_key_exists($core_meta_key, self::getWEFDataTypes($model));
    }
}

<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\CategoryRelationship;
use App\Models\Product;
use Cache;
use Illuminate\Support\Collection;

class CategoryService
{
    public $app;
    protected $categories;

    public function __construct($app) {
        $this->app = $app;

        $cache_key = tenant('id') . '_categories';
        $categories = Cache::get($cache_key, null);
        $default = [];

        if (empty($categories)) {
            $tree = Category::tree()->get()->toTree()->toArray();
            $categories = collect($tree)->recursive_apply('children', ['fn' => 'keyBy', 'params' => ['slug']]);

            // Cache the categories if they are found in DB
            if (!empty($categories)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $categories);
            }
        }

        $this->categories = !empty($categories) ? $categories : $default;
    }

    /**
     * Get all categories in a tree structured collection
     *
     * @return array
     */
    public function getAll() {
        return $this->categories;
    }

    /**
     * Get a tree or flat structured collection of Category and it's children categories
     * using an identificator - ID or slug
     *
     * @param mixed $identificator category slug or ID
     * @param string $type Determines if return collection is 'tree' or 'flat'
     * @return mixed
     */
    public function getChildrenAndSelf($identificator, $type = 'flat') {
        $category = (ctype_digit($identificator) || is_int($identificator)) ? Category::find($identificator) : Category::where('slug', $identificator)->first();

        if($type === 'flat') {
            return $category->descendantsAndSelf()->withCount(['products', 'companies'])->get();
        } else {
            return $category->descendantsAndSelf()->withCount(['products', 'companies'])->get()->toTree();
        }
    }

    /**
     * Restrict Product Builder by adding the categories IDs WHERE IN clause.
     *
     * @param mixed $categories Array of categories IDs
     * @param null $builder Pointer to Eloquent Builder instance
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function restrictByCategories($categories = [], &$builder = null) {
        if(!empty($categories)) {
            $subject_type = $builder->getModel()::class;
            $subject_table_name = $builder->getModel()->getTable();

            if($categories instanceof Collection) {
                $data_type = gettype($categories->first());
                if($data_type === 'object' && get_class($categories->first()) === Category::class) {
                    $categories = $categories->pluck('id')->toArray();
                } else if($data_type === 'integer') {
                    $categories = $categories->toArray();
                }
            }

            $builder->distinct()
                    ->select($subject_table_name.'.*')
                    ->join(app(CategoryRelationship::class)->getTable().' AS cr', 'cr.subject_id', '=', $subject_table_name.'.id')
                    ->where('cr.subject_type', '=', $subject_type)
                    ->whereIn('cr.category_id', $categories);
        }

        return $builder;
    }

}

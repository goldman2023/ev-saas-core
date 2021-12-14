<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\CategoryRelationship;
use Cache;
use Illuminate\Support\Collection;
use Str;

class CategoryService
{
    public $app;
    protected $categories;
    protected $categories_flat;
    protected $pluckable_categories;

    public function __construct($app) {
        $this->app = $app;

        $cache_key = tenant('id') . '_categories';
        $cache_key_flat = tenant('id') . '_categories_flat';

        $categories = Cache::get($cache_key, null);
        $categories_flat = Cache::get($cache_key_flat, null);
        $default = [];

        if (empty($categories_flat)) {
            $categories_flat = Category::tree()->withCount(['products', 'shops'])->get()->keyBy('slug');

            if (!empty($categories_flat)) {
                Cache::forget($cache_key_flat);
                Cache::put($cache_key_flat, $categories_flat);
            }

            $tree = $categories_flat->toTree();

            $categories = collect($tree)->recursiveApply('children', ['fn' => 'keyBy', 'params' => ['slug']]);

            // Cache the categories if they are found in DB
            if (!empty($categories)) {
                Cache::forget($cache_key);
                Cache::put($cache_key, $categories);
            }
        }

        $this->categories_flat = !empty($categories_flat) ? $categories_flat : $default;
        $this->categories = !empty($categories) ? $categories : $default;
        $this->pluckable_categories = Collection::wrap([$this->categories->all()]);
    }

    /**
     * Get all categories in a tree structured collection
     *
     * @param bool $flat
     * @return array
     */
    public function getAll(bool $flat = false)
    {
        return $flat ? $this->categories_flat : $this->categories;
    }

    /*
     * IMPORTANT: For some weird reason, $this->categories->toArray() doesn't properly turn children to slug => $child assoc array and instead, resets all keys of each children property to 0,1,2 etc.
     * In order to properly use categories in JS WE NEED children items to be keyed by their slug so we can access them in JS by using dot notation, like:
     * `Airsoft-a0I2y.children.Airsoft-accessories-BaX7G.children.Airsoft-grenades-59hlx` -> This is not possible if children keys are numeric (o,1,2,3 etc.)
     * This actually worked properly before but for some weird reason, it doesn't work anymore ---___---
     */
    public function getAllFormatted() {
        return Collection::recursiveApplyStatic($this->categories->toArray(), 'children', ['fn' => 'keyBy', 'params' => ['slug']]);
    }

    /**
     * Get specific category by slug_path property
     *
     * @param ?string $slug_path
     * @return mixed|null
     */
    public function getBySlugPath(string $slug_path = null) {
        return $slug_path ? $this->pluckable_categories->pluck(Str::replace(Category::PATH_SEPARATOR,'.children.', $slug_path))->first() : null;
    }

    /**
     * Restrict Product Builder by adding the categories IDs WHERE IN clause.
     *
     * @param mixed $categories Array of categories IDs
     * @param null $builder Pointer to Eloquent Builder instance
     * @return \Illuminate\Database\Eloquent\Builder|null
     */
    public function restrictByCategories($categories = [], &$builder = null) {
        if(!empty($categories)) {
            $subject_type = $builder->getModel()::class;
            $subject_table_name = $builder->getModel()->getTable();

            if($categories instanceof Collection) {
                $data_type = gettype($categories->first());
                if($data_type === 'object' && $categories->first() instanceof Category) {
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

    /**
     * Get a tree or flat structured collection of Category and it's children categories
     * using an identificator - ID or slug
     *
     * @param mixed $identificator category slug or ID
     * @param string $type Determines if return collection is 'tree' or 'flat'
     * @return mixed
     */
    public function getChildrenAndSelf($identificator, $type = 'flat') {
        $search_property = (ctype_digit($identificator) || is_int($identificator)) ? 'id' : 'slug';

        $category = $this->categories->recursiveFind('children', $search_property, $identificator);

        if(empty($category)) {
            $category = (ctype_digit($identificator) || is_int($identificator)) ? Category::find($identificator) : Category::where('slug', $identificator)->first();

            if(empty($category)) {
                return null;
            }

            if($type === 'flat') {
                return $category->descendantsAndSelf()->withCount(['products', 'shops'])->get();
            } else {
                return $category->descendantsAndSelf()->withCount(['products', 'shops'])->get()->toTree();
            }
        }

        if($type === 'flat') {
            $flattened = new \Staudenmeir\LaravelAdjacencyList\Eloquent\Collection([$category]);

            return (!empty($category->children) && $category->children->isNotEmpty()) ? $flattened->merge($category->children->flattenTree('children')) : $flattened;
        }

        return $category;
    }
}

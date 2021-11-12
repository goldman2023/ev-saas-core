<?php

namespace App\Traits;

use App\Models\Category;

trait CategoryTrait
{
    public $category_id; // TODO: This should be removed in future, once the code in admin is fixed in all places!

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootCategoryTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model):void {
            $this->categories; // Populate categories data
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeCategoryTrait(): void
    {
        $this->append(['category_id']);
        $this->fillable(array_unique(array_merge($this->fillable, ['category_id'])));
    }

    /************************************
     * Category Relation Functions *
     ************************************/
    public function categories()
    {
        return $this->morphToMany(Category::class, 'subject', 'category_relationships', null, 'category_id');
    }

    /************************************
     * Category Attributes Getters/Setters *
     ************************************/
    public function getCategoryIdAttribute() {
        if(empty($this->category_id)) {
            $this->category_id = $this->categories()->whereNull('parent_id')->first()->id ?? null;
        }

        return $this->category_id;
    }

    /************************************
     * Category Functions *
     ************************************/
    public function selected_categories($pluck_property = null, $is_collection = true, $toTree = false) {
        $data = $this->categories;

        if($pluck_property) {
            $data = $data->pluck($pluck_property);
        }

        if($toTree) {
            $data = $data->toTree();
        }

        if(!$is_collection) {
            $data = $data->toArray();
        }

        return $data;
    }

}

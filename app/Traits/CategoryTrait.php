<?php

namespace App\Traits;

use App\Models\Category;

trait CategoryTrait
{
    public $category_id; // TODO: This should be removed in future, once the code in admin is fixed in all places!
    public $primary_category;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootCategoryTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::relationsRetrieved(function ($model):void {
            if(!$model->relationLoaded('categories')) {
                $model->load('categories');
            }
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeCategoryTrait(): void
    {
        $this->append(['category_id', 'primary_category']);
        $this->fillable(array_unique(array_merge($this->fillable, ['category_id', 'primary_category'])));
    }

    /************************************
     * Category Relation Functions *
     ************************************/
    public function categories()
    {
        return $this->morphToMany(Category::class, 'subject', 'category_relationships', 'subject_id');
    }

    /************************************
     * Category Attributes Getters/Setters *
     ************************************/
    public function getCategoryIdAttribute() {
        if(!isset($this->category_id)) {
            $this->category_id = $this->categories->whereNull('parent_id')->first()->id ?? null;
        }

        return $this->category_id;
    }

    public function getPrimaryCategoryAttribute() {
        if(!isset($this->primary_category)) {
            $this->primary_category = $this->categories->whereNull('parent_id')?->first();
        }

        return $this->primary_category;
    }

    /************************************
     * Category Functions *
     ************************************/
    public function selected_categories($pluck_property = null, $is_collection = true, $toTree = false) {
        $data = $this->categories;
        $all_categories = \Categories::getAll(true);

        $selected_categories = $all_categories->whereIn('slug', $data->pluck('slug')->toArray());

        if($pluck_property) {
            $selected_categories = $selected_categories->pluck($pluck_property);
        }

        if($toTree) {
            $selected_categories = $selected_categories->toTree();
        }

        if(!$is_collection) {
            $selected_categories = $selected_categories->toArray();
        }

        return $selected_categories;
    }

}

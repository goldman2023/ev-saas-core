<?php

namespace App\Traits;


use App\Models\Brand;
use App\Models\ProductVariation;

trait BrandTrait
{
    public $brand_id;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootBrandTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model) {
            $model->getBrandIdAttribute();

            $model->load('brand');
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeBrandTrait(): void
    {
        $this->append(['brand_id']);
    }

    /************************************
     * Brand Relation Functions *
     ************************************/
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /************************************
     * Stock Attributes Getters/Setters *
     ************************************/
    public function getBrandIdAttribute() {
        // TODO: Create brand_relationships table (polymorphic) so we can attach different content types to Brands in n-to-n fashion.
        if(!empty($this->attributes['brand_id'] ?? null)) {
            // Load the brand relation
            $this->brand_id = $this->attributes['brand_id'];

            return $this->attributes['brand_id'];
        } else {
            return 0;
        }

    }
}

<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\Brand;
use App\Models\ProductVariation;

trait BrandTrait
{
    //public $brand_id;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootBrandTrait()
    {
        // static::addGlobalScope('withBrand', function (mixed $builder) {
        //     // Eager Load Brand
        //     //$builder->with(['brand']);
        // });

        // When model data is retrieved, populate model stock data!
        static::relationsRetrieved(function ($model) {
            // if ($model->relationLoaded('brand')) {
            //     $model->getBrandIdAttribute();
            // }
        });
    }

    /**
     * Initialize the trait
     *
     * @return void
     */
    // public function initializeBrandTrait(): void
    // {
    //     //$this->append(['brand_id']);
    // }

    // /************************************
    //  * Brand Relation Functions *
    //  ************************************/
    // public function brand()
    // {
    //     return $this->belongsTo(Brand::class, 'brand_id');
    // }

    // /************************************
    //  * Stock Attributes Getters/Setters *
    //  ************************************/
    // public function getBrandIdAttribute()
    // {
    //     // TODO: Create brand_relationships table (polymorphic) so we can attach different content types to Brands in n-to-n fashion.
    //     return $this->attributes['brand_id'];
    // }

    // public function setBrandIdAttribute($value)
    // {
    //     $this->attributes['brand_id'] = $value;
    // }
}

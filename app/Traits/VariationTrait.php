<?php

namespace App\Traits;


use App\Models\ProductVariation;

trait VariationTrait
{
    /************************************
     * Abstract Trait Methods *
     ************************************/
    abstract public function useVariations(): ?bool;

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootVariationTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::retrieved(function ($model) {
            if($model->useVariations() && !isset($model->variations)) {
                $model->load('variations');
            }
        });
    }

    /**
     * Checks if Model has any variations.
     * Use this function to determine logic for dependent traits, like:
     * 1. Price calculation functions
     * etc.
     *
     * @return void
     */
    public function hasVariations(): bool
    {
        return $this->useVariations() ? ($this->variations->isNotEmpty() ?? false) : false;
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }
}

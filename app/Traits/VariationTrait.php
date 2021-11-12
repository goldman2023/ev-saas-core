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
            if($model->useVariations()) {
                $model->load('variations');
            }
        });
    }

    public function hasVariations() {
        return $this->useVariations() ? ($this->variations->isNotEmpty() ?? false) : false;
    }

    public function variations() {
        if($this->useVariations()) {
            return $this->hasMany(ProductVariation::class);
        }

        return null;
    }
}

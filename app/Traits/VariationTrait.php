<?php

namespace App\Traits;


use App\Models\ProductVariation;

trait VariationTrait
{

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

    public function useVariations(): ?bool
    {
        return $this->variant_attributes()->count() > 0;
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
        return $this->useVariations() && $this->variations->isNotEmpty() && $this->variant_attributes()->isNotEmpty();
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }

    public function getMappedVariations($convert_uploads = true, $refresh = false) {
        if($refresh) {
            return $this->variations()->get()->map(fn($item) => $convert_uploads ? $item->convertUploadModelsToIDs() : $item )->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']));
        }

        return $this->variations->map(fn($item) => $convert_uploads ? $item->convertUploadModelsToIDs() : $item )->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']));
    }
}

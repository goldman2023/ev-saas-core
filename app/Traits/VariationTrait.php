<?php

namespace App\Traits;


use App\Builders\BaseBuilder;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Relations\Relation;

trait VariationTrait
{
    /*
     * Gets the class of the Variations Model (e.g. For Product Model, ProductVariation is the variation model class)
     */
    abstract public function getVariationModelClass();
    abstract public function main();


    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootVariationTrait()
    {
        // When model data is retrieved, populate model stock data!
        static::relationsRetrieved(function ($model) {
            if($model->useVariations() && !$model->relationLoaded('variations')) {
                $model->load('variations');
            }

//            if($model->isMain()) {
//                // If it's a main model, set all variations main relation to main model! Reason is less DB queries.
//                $model->variations->map(function($variation) use ($model) {
//                    $variation->setMain($model);
//                    return $variation;
//                });
//            }
        });
    }

    public function useVariations(): ?bool
    {
        if(empty($this->getVariationModelClass()))
            return false;

        // Does NOT query the database
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
        return $this->hasMany($this->getVariationModelClass()['class'] ?? null);
    }

    public function getMappedVariations($convert_uploads = true, $refresh = false) {
        if(empty($this->getVariationModelClass()))
            return null;

        if($refresh) {
            return $this->variations->get()->map(fn($item) => $convert_uploads ? $item->convertUploadModelsToIDs() : $item )->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']));
        }

        return $this->variations->map(fn($item) => $convert_uploads ? $item->convertUploadModelsToIDs() : $item )->keyBy(fn($item) => ProductVariation::composeVariantKey($item['name']));
    }

//    public function getFirstVariation() {
//        $variant = [];
//        foreach($this->variant_attributes() as $attribute)  {
//            $variant[] = [
//                'attribute_value_id' => $attribute->attribute_values->first()->id, // Take the first attribute_value as initial selected variant
//                'attribute_id' => $attribute->id
//            ];
//        }
//        dd($this->variations);
//        // Get the first ProductVariation
//        return $this->variations->filter(function($item, $key) use ($variant) {
//            $item_variant = array_values($item->variant); // reset keys just in case
//            $variant = array_values($variant); // reset keys just in case
//
//            array_multisort($item_variant); // sort item variant array
//            array_multisort($variant); // sort variant array
//
//            return serialize($item_variant) === serialize($variant); // check if these two are of same serialized value!
//            // NOTE: Only this approach works because we are NOT USING attribute_id as key of each element in variant array (cuz of livewire!) AND items inside `variant` can change place
//        })->first();
//    }

    public function getVariationByVariant($variant) {
        if(empty($this->getVariationModelClass()))
            return null;

        // Get the first ProductVariation
        return $this->variations->filter(function($item, $key) use ($variant) {
            $item_variant = $variant instanceof Collection ? collect($item->variant)->values()->toArray() : array_values($item->variant); // reset keys just in case
            $variant = $variant instanceof Collection ? $variant->values()->toArray() : array_values($variant); // reset keys just in case

            array_multisort($item_variant); // sort item variant array
            array_multisort($variant); // sort variant array

            return serialize($item_variant) === serialize($variant); // check if these two are of same serialized value!
            // NOTE: Only this approach works because we are NOT USING attribute_id as key of each element in variant array (cuz of livewire!) AND items inside `variant` can change place
        })->first();
    }

    public function getMissingVariations($return_as_variants = false) {
        if(empty($this->getVariationModelClass()))
            return null;

        $missing_combinations = $return_as_variants ? collect() : new \Illuminate\Database\Eloquent\Collection();

        $available_variants = $this->variations->pluck('variant');
        $all_variants = $this->createAllVariationsCombinations(true);

        return $all_variants->filter(function($item, $key) use ($available_variants) {
            $item_variant = array_values($item); // reset keys just in case
            array_multisort($item_variant);

            $pass = true;
            foreach($available_variants as $index => $available_variant) {
                $available_variant = array_values($available_variant); // reset keys just in case
                array_multisort($available_variant); // sort variant array

                $pass = !(serialize($item_variant) === serialize($available_variant)); // check if available_variant is same as the current from all_variants. If true, skip item cuz it's an available item!
                if(!$pass) break; // if $pass is false, break loop and do not include item as a missing variations cuz it's actually an available variation!
            }

            if($pass) {
                return true;
            }

            return false;
        })->values();
    }

    /*
     * Create all Model Variations Combinations
     *
     * In order for livewire JS to understand that all_combinations and variations are Model Collections, both of these properties
     * MUST BE of Illuminate\Database\Eloquent\Collection, NOT JUST Illuminate\Support\Collection!
     * If collection is standard (not Eloquent) then Livewire JS will treat collection models as arrays and no Model hydration will happen on next backend call!
     * Basically, it's same as calling Model->toArray() for each model inside collection. So, for Models use Eloquent/Collection!
     */
    public function createAllVariationsCombinations($return_as_variants = false) {
        if(empty($this->getVariationModelClass()))
            return null;

        $all_combinations = $return_as_variants ? collect() : new \Illuminate\Database\Eloquent\Collection();

        // Create all possible combinations
        // NOTE: Check AttributeTrait generateVariantAttributeValuesMatrix() function DOComment to know more about return types!
        $matrix = $this->generateVariantAttributeValuesMatrix();

        if($matrix instanceof Collection && $matrix->isNotEmpty()) {
            foreach($matrix as $index => $combo) {
                if(empty($combo)) {
                    continue;
                }

                $variant_data = [];

                if($combo instanceof AttributeValue) {
                    $variant_data[] = [
                        'attribute_value_id' => $combo->id,
                        'attribute_id' => $combo->attribute_id,
                    ];
                } else {
                    foreach($combo as $value) {
                        $variant_data[] = [
                            'attribute_value_id' => $value->id,
                            'attribute_id' => $value->attribute_id,
                        ];
                    }
                }

                if(!$return_as_variants) {
                    $variation = app($this->getVariationModelClass()['class']);
                    $variation->id = null;
                    $variation->{$this->getVariationModelClass()['foreign_key']} = $this->id ?? null;
                    $variation->variant = $variant_data;
                    $variation->price = $this->unit_price ?? 0;
                    $variation->discount = 0;
                    $variation->discount_type = 'percent';
                    $variation->thumbnail = null;
                    $variation->current_stock = 0;
                    $variation->sku = '';

                    $all_combinations->push($variation);
                } else {
                    $all_combinations->push($variant_data);
                }

            }
        }

        return $all_combinations;
    }

    /*
     * Methods related to Main <--> Variation
     */
    public function getMain() {
        return ($this->main() instanceof Relation) ? $this->main : null;
    }

    public function setMain($model): void
    {
        $this->setRelation('main', $model);
    }

    public function hasMain() {
        return $this->main() instanceof Relation;
    }

    public function isMain() {
        return empty($this->main());
    }
}

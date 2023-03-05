<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Str;
use App\Support\Eloquent\Relations\EmptyRelation;

trait VariationTrait
{
    protected $variations_loaded = false;

    /*
     * Gets the class of the Variations Model (e.g. For Product Model, ProductVariation is the variation model class)
     */
    abstract public function getVariationModelClass();

    /**
     * Boot the trait
     *
     * @return void
     */
    protected static function bootVariationTrait()
    {
        static::addGlobalScope('withVariations', function (mixed $builder) {
            $builder->with(['variations']);
        });

        // When model data is retrieved, check if model uses variations and variations are not retrieved
        static::relationsRetrieved(function ($model) {
            $cloned_model = clone $model;

            if (!$model->relationLoaded('variations') && $model->useVariations()) {
                $model->load('variations');
            }
            
            if(!$model->variations_loaded) {
                /** 
                 * In order to reduce number of queries when variation calls for main (->main) and loading all main relations again,
                 * We'll SET main PROPERTY of each variant to current $model.
                 * Reason is that it has all needed relations that variant may use (as attributes/att_values/att_relations, since they are needed for variant name construction and other important things) 
                 * Also, we'll remove all unnecessary relations from $cloned_model and leave only those variations will use (like custom_attributes)
                 */
                $only_custom_attributes_rel = array_intersect_key($cloned_model->getRelations(), array_flip(['custom_attributes']) );
                $cloned_model->setRelations($only_custom_attributes_rel);
                
                // Inject main model to `main` core property and generate variation name
                $model->variations->map(function($variation) use($cloned_model) {
                    $variation->main = $cloned_model;
                    $variation->name = $variation->getVariantName(slugified: true);
                });

                $model->variations_loaded = true;
            }
            
        });
    }

    public function useVariations(): ?bool
    {
        if (empty($this->getVariationModelClass())) {
            return false;
        }

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

    public function variations()
    {
        if (empty($this->getVariationModelClass())) {
            return new EmptyRelation($this);
        }
        
        return $this->hasMany($this->getVariationModelClass()['class'] ?? null);
    }

    public function getMappedVariations($refresh = false)
    {
        if (empty($this->getVariationModelClass())) {
            return null;
        }
        
        if ($refresh) {
            return $this->variations->get()->keyBy(fn ($item) => ProductVariation::composeVariantKey($item['name']));
        }
        
        return $this->variations->keyBy(fn ($item) => ProductVariation::composeVariantKey($item['name']));
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

    public function getVariationByVariant($variant)
    {
        if (empty($this->getVariationModelClass())) {
            return null;
        }

        // Get the first ProductVariation
        return $this->variations->filter(function ($item, $key) use ($variant) {
            $item_variant = $variant instanceof Collection ? collect($item->variant)->values()->toArray() : array_values($item->variant); // reset keys just in case
            $variant = $variant instanceof Collection ? $variant->values()->toArray() : array_values($variant); // reset keys just in case

            array_multisort($item_variant); // sort item variant array
            array_multisort($variant); // sort variant array

            return serialize($item_variant) === serialize($variant); // check if these two are of same serialized value!
            // NOTE: Only this approach works because we are NOT USING attribute_id as key of each element in variant array (cuz of livewire!) AND items inside `variant` can change place
        })->first();
    }

    public function getMissingVariations($return_as_variants = false)
    {
        if (empty($this->getVariationModelClass())) {
            return null;
        }

        $missing_combinations = $return_as_variants ? collect() : new \Illuminate\Database\Eloquent\Collection();

        $available_variants = $this->variations->pluck('variant');
        $all_variants = $this->createAllVariationsCombinations(true);

        return $all_variants->filter(function ($item, $key) use ($available_variants) {
            $item_variant = array_values($item); // reset keys just in case
            array_multisort($item_variant);

            $pass = true;
            foreach ($available_variants as $index => $available_variant) {
                $available_variant = array_values($available_variant); // reset keys just in case
                array_multisort($available_variant); // sort variant array

                $pass = ! (serialize($item_variant) === serialize($available_variant)); // check if available_variant is same as the current from all_variants. If true, skip item cuz it's an available item!
                if (! $pass) {
                    break;
                } // if $pass is false, break loop and do not include item as a missing variations cuz it's actually an available variation!
            }

            if ($pass) {
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
    public function createAllVariationsCombinations($return_as_variants = false)
    {
        if (empty($this->getVariationModelClass())) {
            return null;
        }

        $all_combinations = $return_as_variants ? collect() : new \Illuminate\Database\Eloquent\Collection();

        // Create all possible combinations
        // NOTE: Check AttributeTrait generateVariantAttributeValuesMatrix() function DOComment to know more about return types!
        $matrix = $this->generateVariantAttributeValuesMatrix();

        if ($matrix instanceof Collection && $matrix->isNotEmpty()) {
            $cloned_model = clone $this;
            $cloned_model->setRelations(array_intersect_key($cloned_model->getRelations(), array_flip(['custom_attributes']) ));

            foreach ($matrix as $index => $combo) {
                if (empty($combo)) {
                    continue;
                }

                $variant_data = [];

                if ($combo instanceof AttributeValue) {
                    $variant_data[] = [
                        'attribute_value_id' => $combo->id,
                        'attribute_id' => $combo->attribute_id,
                    ];
                } else {
                    foreach ($combo as $value) {
                        $variant_data[] = [
                            'attribute_value_id' => $value->id,
                            'attribute_id' => $value->attribute_id,
                        ];
                    }
                }

                if (! $return_as_variants) {
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

                    // Append Main and name
                    $variation->main = $cloned_model;
                    $variation->name = $variation->getVariantName(slugified: true);

                    $all_combinations->push($variation);
                } else {
                    $all_combinations->push($variant_data);
                }
            }
        }

        return $all_combinations;
    }

}

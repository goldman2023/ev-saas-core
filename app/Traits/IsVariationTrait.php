<?php

namespace App\Traits;

use App\Builders\BaseBuilder;
use App\Models\AttributeValue;
use App\Models\ProductVariation;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;
use Str;

trait IsVariationTrait
{
    public ?bool $is_variation = true;
    public $name = null;
    public $main = null;

    /**
     * Initialize the trait
     *
     * @return void
     */
    public function initializeIsVariationTrait(): void
    {
        $this->appendCoreProperties(['is_variation', 'name', 'main']);
        $this->append(['is_variation', 'name', 'main']);
    }

    protected static function bootIsVariationTrait()
    {

    }

    public function getMain()
    {
        return $this->main;
    }

    // If $value is null or empty, value should always be empty array!
    // Reason: Ease of use in frontend and backend views
    public function getVariantAttribute($value) {
        $atts = $this->castAttribute('variant', $value);
        return empty($atts) ? [] : $atts;
    }


    public function getVariantName($attributes = [], $slugified = false, $value_separator = '-', $as_collection = false, $key_by = null) {
        $att_values_idx = [];
        $name = '';

        if(!empty($this->variant)) {
            foreach($this->variant as $item) {
                if(!empty($item['attribute_value_id'])) {
                    $att_values_idx[] = $item['attribute_value_id'];
                }
            }
            
            if(!empty($attributes)) {
                $att_values = $attributes->map(function($item) use($att_values_idx) {
                    return $item->attribute_values->filter(fn($val) => in_array($val->id, $att_values_idx))->first();
                });
            } else {
                // If attributes are not provided as parameter, get variant_attributes from main
                // $att_values = AttributeValue::whereIn('id', $att_values_idx)->select('values AS name')->get();
                $att_values = $this->main->variant_attributes(key_by: ($key_by ?:null))->map(function($item) use($att_values_idx) {
                    return $item->attribute_values->filter(fn($val) => in_array($val->id, $att_values_idx))->first();
                });
            }

            if(!empty($key_by)) {
                return $att_values->map(fn($item) => $item->values);
            }

            if($as_collection) {
                return $att_values->unique()->values()->pluck('values');
            }
            
            foreach($att_values as $key => $value) {
                if($slugified) {
                    $name .= $value->values.($key+1 !== $att_values->count() ? '-' : '');
                } else {
                    $name .= $value->values.($key+1 !== $att_values->count() ? $value_separator : '');
                }
            }

            if($slugified) {
                $name = Str::slug($name);
            }

        }

        return self::composeVariantKey($name);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public static function composeVariantKey($key) {
        return Str::slug(Str::replace('.', ',', $key));
    }
}

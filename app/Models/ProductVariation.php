<?php

namespace App\Models;

use App\Events\Products\ProductVariationDeleting;
use App\Models\Central\Tenant;
use App\Traits\AttributeTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\Caching\SavesToCache;
use App\Traits\GalleryTrait;
use App\Traits\PermalinkTrait;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\StockManagementTrait;
use App\Traits\UploadTrait;
use App\Traits\VariationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReviewTrait;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\Sluggable\HasSlug;
use Str;

/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $product_id
 * @property string $variant
 * @property string $image
 * @property float $price
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @mixin \Eloquentf
 */

class ProductVariation extends EVBaseModel
{
    use Notifiable;
    use SoftDeletes;

    use AttributeTrait;

    use UploadTrait;
    use GalleryTrait;

    use StockManagementTrait;
    use PriceTrait;
    use Purchasable;

    use ReviewTrait;

    use VariationTrait;

    // Default atts
    protected $attributes = [
        'price' => 0,
        'discount' => 0,
    ];

    /**
     * The relationships that should always be loaded.
     * NOTE: Uploads, Attribute, Price and Stock traits are eager loading all relationships by default
     *
     * @var array
     */
    protected $with = [];

    protected $fillable = ['product_id', 'variant', 'price', 'discount', 'discount_type', 'created_at', 'updated_at'];
    //protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'discount', 'discount_type', 'name'];

    protected $casts = [
        'variant' => 'array',
    ];

    public static function booted()
    {
        static::relationsRetrieved(function ($model) {
//            $model->appendCoreProperties(['name']);
//            $model->append(['name']);
//            $model->initCoreProperties(only: ['name']);
        });
    }

    public function main()
    {
        //dd($this->belongsTo(Product::class, 'product_id', 'id')->without(Product::$defaultEagerLoads)->first());
        return $this->belongsTo(Product::class, 'product_id', 'id')->without(Product::$defaultEagerLoads);
    }

    public function getNameAttribute() {
        $att_values_idx = [];
        $name = '';
//        dd($this->main);
//        return json_encode($this->variant);

        if(!empty($this->variant)) {
            foreach($this->variant as $item) {
                if(!empty($item['attribute_value_id'])) {
                    $att_values_idx[] = $item['attribute_value_id'];
                }
            }

            // TODO: Fix this to use parent product attribute values, so we don't have to query this part!
            $att_values = AttributeValue::whereIn('id', $att_values_idx)->select('values AS name')->get();
            foreach($att_values as $key => $value) {
                $name .= Str::slug($value->name.($key+1 !== $att_values->count() ? '-' : ''));
            }
        }

        return $name;
    }

    /*
     * TODO: Think about moving this to a Trait because different ContentType Variations can use it!
     */
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
//                $att_values = AttributeValue::whereIn('id', $att_values_idx)->select('values AS name')->get();
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
                    $name .= Str::slug($value->values.($key+1 !== $att_values->count() ? '-' : ''));
                } else {
                    $name .= $value->values.($key+1 !== $att_values->count() ? $value_separator : '');
                }
            }

        }

        return $name;
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    // START: Casts section
    // If $value is null or empty, value should always be empty array!
    // Reason: Ease of use in frontend and backend views
    public function getVariantAttribute($value) {
        $atts = $this->castAttribute('variant', $value);
        return empty($atts) ? [] : $atts;
    }
    // END: Casts section

    // MISC
    public static function composeVariantKey($key) {
        return Str::slug(Str::replace('.', ',', $key));
    }

    /**
     * Returns column name of the price
     *
     * @return string
     */
    public function getPriceColumn(): string
    {
        return 'price';
    }


    public function useVariations(): ?bool
    {
        return false;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    public function getVariationModelClass()
    {
        return null;
    }
}

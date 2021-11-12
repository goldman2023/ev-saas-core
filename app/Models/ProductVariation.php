<?php

namespace App\Models;

use App\Events\Products\ProductVariationDeleting;
use App\Traits\AttributeTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\Caching\SavesToCache;
use App\Traits\GalleryTrait;
use App\Traits\PermalinkTrait;
use App\Traits\PriceTrait;
use App\Traits\StockManagementTrait;
use App\Traits\UploadTrait;
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
 * @mixin \Eloquent
 */

class ProductVariation extends Model
{
    use Notifiable;
    use SoftDeletes;

    use AttributeTrait;

    use UploadTrait;
    use GalleryTrait;

    use StockManagementTrait;
    use PriceTrait;

    use ReviewTrait; // TODO: Is this necessary?

    /* Properties not saved in DB */
    public bool $remove_flag;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['custom_attributes', 'stock', 'flash_deals', 'uploads'];

    protected $fillable = ['product_id', 'variant', 'image', 'price', 'remove_flag', 'discount', 'discount_type'];
    //protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'discount', 'discount_type', 'name', 'remove_flag'];

    protected $casts = [
        'variant' => 'array',
    ];

    protected $appends = ['name', 'remove_flag'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getNameAttribute() {
        $att_values_idx = [];
        $name = '';

        if(!empty($this->variant)) {
            foreach($this->variant as $item) {
                if(!empty($item['attribute_value_id'])) {
                    $att_values_idx[] = $item['attribute_value_id'];
                }
            }

            // TODO: Fix this to use parent product attribute values, so we don't have to query this part!
            $att_values = AttributeValue::whereIn('id', $att_values_idx)->select('values AS name')->get();
            foreach($att_values as $key => $value) {
                $name .= $value->name.($key+1 !== $att_values->count() ? '-' : '');
            }
        }

        return $name;
    }

    public function setRemoveFlagAttribute($value)
    {
        $this->remove_flag = $value;
    }

    public function getRemoveFlagAttribute() {
        return $this->remove_flag ?? false;
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

    public function getPriceColumn()
    {
        return 'price';
    }
}

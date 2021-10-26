<?php

namespace App\Models;

use App\Events\Products\ProductVariationDeleting;
use App\Facades\FX;
use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReviewTrait;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Notifications\Notifiable;
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
    use ReviewTrait;
    use AttributeTrait;
    use Notifiable;

    /* Properties not saved in DB */
    public bool $remove_flag;
    public $total_price;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['stock', 'flash_deals'];

    protected $fillable = ['product_id', 'variant', 'image', 'price', 'remove_flag'];
    protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'name', 'temp_stock', 'remove_flag', 'total_price'];

    protected $casts = [
        'variant' => 'array',
    ];

    protected $appends = ['name', 'image_url', 'temp_stock', 'remove_flag', 'total_price'];

    protected $dispatchesEvents = [
        'deleting' => ProductVariationDeleting::class,
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->morphOne(ProductStock::class, 'subject');
    }

    public function flash_deals() {
        // TODO: Add indicies to start_date and end_date!
        return $this->morphToMany(FlashDeal::class, 'subject', 'flash_deal_relationships', 'subject_id', 'flash_deal_id')
            ->where([
                ['status', '=', 1],
                ['start_date', '<=', time()],
                ['end_date', '>', time()],
            ])->orderBy('created_at', 'desc')->withPivot('include_variations');
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
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

            $att_values = AttributeValue::whereIn('id', $att_values_idx)->select('values AS name')->get();
            foreach($att_values as $key => $value) {
                $name .= $value->name.($key+1 !== $att_values->count() ? '-' : '');
            }
        }

        return $name;
    }

    public function setTempStockAttribute($value)
    {
        $this->attributes['temp_stock'] = $value;
    }

    public function getTempStockAttribute() {
        if(!isset($this->attributes['temp_stock'])) {
            $stock = $this->stock()->first();

            return $stock ?: collect([
                'qty' => 0,
                'sku' => ''
            ]);
        }

        return $this->attributes['temp_stock'];
    }

    public function getImageUrlAttribute() {
        if(!empty($this->attributes['image'] ?? null)) {
            return uploaded_asset($this->attributes['image']);
        }

        return '';
    }

    public function setRemoveFlagAttribute($value)
    {
        $this->remove_flag = $value;
    }

    public function getRemoveFlagAttribute() {
        return $this->remove_flag ?? false;
    }

    /**
     * Get product end(total) price
     *
     * NOTE: Total price is a price of the product after all discounts, but without Tax included
     *
     * @param bool $display
     * @return float $total
     */
    public function getTotalPrice($display = false) {
        $this->total_price = $this->attributes['price'];
        /*if(empty($this->total_price)) {
            $this->total_price = $this->attributes['price'];

            $flash_deal = $this->flash_deals->first() ?: $this->product->flash_deals->filter(function($value,$key) {
                return (int) $value->pivot->include_variations === 1;
            })->first();

            if(!empty($flash_deal)) {
                if ($flash_deal->discount_type === 'percent') {
                    $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                } elseif ($flash_deal->discount_type === 'amount') {
                    $this->total_price -= $flash_deal->discount;
                }
            }
        }*/

        return $display ? FX::formatPrice($this->total_price) : $this->total_price;
    }

    public function getOriginalPrice($display = false) {
        return $display ? FX::formatPrice($this->attributes['price']) : $this->attributes['price'];
    }

    public function getTotalPriceAttribute() {
        return $this->getTotalPrice();
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
        return Str::replace('.', ',', $key);
    }
}

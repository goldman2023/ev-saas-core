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
    public $current_stock;
    public $low_stock_qty;
    public $total_price;
    public $discounted_price;
    public $base_price;

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['stock', 'flash_deals'];

    protected $fillable = ['product_id', 'variant', 'image', 'price', 'remove_flag', 'discount', 'discount_type'];
    protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'discount', 'discount_type', 'name', 'temp_stock', 'remove_flag', 'total_price'];

    protected $casts = [
        'variant' => 'array',
    ];

    protected $appends = ['name', 'image_url', 'temp_stock', 'remove_flag', 'current_stock', 'low_stock_qty', 'category_id', 'total_price', 'discounted_price', 'base_price'];

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

    // START PRICES

    /**
     * Get product total price with tax
     *
     * NOTE: Total price is a price of the product after all discounts and with Tax included
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getTotalPrice(bool $display = false, bool $both_formats = false): mixed
    {
        if(empty($this->total_price)) {
            $this->total_price = $this->attributes['price'];

            // TODO: If Main Product of this variation is under a FlashDeal, take that Flash Deal into consideration too!
            // TODO: For now only flash deals which are directly related to specific ProductVariation are taken into consideration!!!
            $flash_deal = $this->flash_deals->first();

            // NOTE: If FlashDeal is present for current product variation, DO NOT take ProductVariation's discount into consideration!
            if(!empty($flash_deal)) {
                if ($flash_deal->discount_type === 'percent') {
                    $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                } elseif ($flash_deal->discount_type === 'amount') {
                    $this->total_price -= $flash_deal->discount;
                }
            } else {
                if ($this->attributes['discount'] && $this->attributes['discount_type'] === 'percent') {
                    $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                } elseif ($this->attributes['discount'] && $this->attributes['discount_type'] === 'amount') {
                    $this->total_price -= $this->attributes['discount'];
                }
            }

            // TODO: Create tax_relationship table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes

            // NOTE: For now, taxes related to the Main Product are applied to each variation too!!!
            if(!empty($this->product->tax)) {
                if ($this->product->tax_type === 'percent') {
                    $this->total_price += ($this->total_price * $this->product->tax) / 100;
                } elseif ($this->product->tax_type === 'amount') {
                    $this->total_price += $this->product->tax;
                }
            }

        }

        if ($both_formats) {
            return [
                'raw' => $this->total_price,
                'display' => FX::formatPrice($this->total_price)
            ];
        }

        return $display ? FX::formatPrice($this->total_price) : $this->total_price;
    }

    public function getTotalPriceAttribute() {
        return $this->getTotalPrice();
    }

    /**
     * Get Discounted price
     *
     * NOTE: Discounted price is a price of the product after all discounts, but without Tax included
     *
     * @param bool $display
     * @param bool $both_formats
     * @return mixed
     */
    public function getDiscountedPrice(bool $display = false, bool $both_formats = false): mixed
    {
        if(empty($this->discounted_price)) {
            $this->discounted_price = $this->attributes['price'];

            // TODO: If Main Product of this variation is under a FlashDeal, take that Flash Deal into consideration too!
            // TODO: For now only flash deals which are directly related to specific ProductVariation are taken into consideration!!!
            $flash_deal = $this->flash_deals->first();

            // NOTE: If FlashDeal is present for current product variation, DO NOT take ProductVariation's discount into consideration!
            if(!empty($flash_deal)) {
                if ($flash_deal->discount_type === 'percent') {
                    $this->total_price -= ($this->total_price * $flash_deal->discount) / 100;
                } elseif ($flash_deal->discount_type === 'amount') {
                    $this->total_price -= $flash_deal->discount;
                }
            } else {
                if ($this->attributes['discount'] && $this->attributes['discount_type'] === 'percent') {
                    $this->total_price -= ($this->total_price * $this->attributes['discount']) / 100;
                } elseif ($this->attributes['discount'] && $this->attributes['discount_type'] === 'amount') {
                    $this->total_price -= $this->attributes['discount'];
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->discounted_price,
                'display' => FX::formatPrice($this->discounted_price)
            ];
        }

        return $display ? FX::formatPrice($this->discounted_price) : $this->discounted_price;
    }

    public function getDiscountedPriceAttribute() {
        return $this->getDiscountedPrice();
    }

    /**
     * Get Base price
     *
     * NOTE: Base price is the price of the product with product related taxes
     *
     * @param bool $display
     * @param bool $both_formats
     * @return float
     */
    public function getBasePrice(bool $display = false, bool $both_formats = false): mixed{
        if(empty($this->base_price)) {
            $this->base_price = $this->attributes['price'];

            // TODO: Create tax_relationship table and link it to subjects and taxes!
            // TODO: Create Global Taxes (as admin/single-vendor) or subject-specific taxes
            if(!empty($this->attributes['tax'])) {
                if ($this->attributes['tax_type'] === 'percent') {
                    $this->base_price += ($this->base_price * $this->attributes['tax']) / 100;
                } elseif ($this->attributes['tax_type'] === 'amount') {
                    $this->base_price += $this->attributes['tax'];
                }
            }
        }

        if ($both_formats) {
            return [
                'raw' => $this->base_price,
                'display' => FX::formatPrice($this->base_price)
            ];
        }

        return $display ? FX::formatPrice($this->base_price) : $this->base_price;
    }

    public function getBasePriceAttribute() {
        return $this->getBasePrice();
    }

    /**
     * Get Original price
     *
     * NOTE: Original price is the `price` of the ProductVariation (without flash-deals/discounts/taxes etc.)
     *
     * @param bool $display
     * @param bool $both_formats
     * @return float
     */
    public function getOriginalPrice(bool $display = false, bool $both_formats = false): mixed {
        if ($both_formats) {
            return [
                'raw' => $this->attributes['price'],
                'display' => FX::formatPrice($this->attributes['price'])
            ];
        }

        return $display ? FX::formatPrice($this->attributes['price']) : $this->attributes['price'];
    }

    // END PRICES

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
}

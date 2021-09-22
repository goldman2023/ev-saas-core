<?php

namespace App\Models;

use App\Traits\AttributeTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReviewTrait;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

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

    /* Properties not saved in DB */
    protected string $remove_flag;

    protected $fillable = ['product_id', 'variant', 'image', 'price', 'remove_flag'];
    protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'name', 'temp_stock'];

    protected $casts = [
        'variant' => 'array',
    ];

    protected $appends = ['name', 'image_url', 'temp_stock', 'remove_flag'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function stock()
    {
        return $this->morphOne(ProductStock::class, 'subject');
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
        return $this->remove_flag;
    }

    // START: Casts section
    // If $value is null or empty, value should always be empty array!
    // Reason: Ease of use in frontend and backend views
    public function getVariantAttribute($value) {
        $atts = $this->castAttribute('variant', $value);
        return empty($atts) ? [] : $atts;
    }
    // END: Casts section
}

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

    protected $fillable = ['product_id', 'variant', 'image', 'price'];

    protected $casts = [
        'variant' => 'array',
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
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
}

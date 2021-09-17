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
    protected $visible = ['id', 'product_id', 'variant', 'image', 'price', 'name', 'temp_stock'];

    protected $casts = [
        'variant' => 'array',
    ];

    protected $appends = ['name', 'temp_stock'];


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

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return void
     */
    public function setTempStockAttribute($value)
    {
        $this->attributes['temp_stock'] = $value;
    }

    public function getTempStockAttribute() {
        return $this->attributes['temp_stock'];
    }

    public function getImageAttribute() {
        $url = '';

        if(!empty($this->image ?? null)) {
            $url = str_replace('tenancy/assets/', '', my_asset($this->image)); /* TODO: This is temporary fix */

            if(config('imgproxy.enabled') == true) {
                // TODO: Create an ImgProxyService class and Imgproxy facade to construct links with specific parameters and signature
                // TODO: Put an Imgproxy server behind a CDN so it caches the images and offloads the server!
                // TODO: Enable SSL on imgproxy server and add certificate for images.ev-saas.com subdomain
                $url = config('imgproxy.host').'/insecure/fill/0/0/ce/0/plain/'.$url.'@webp'; // generate webp on the fly through imgproxy
            }
        }

        return $url;
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

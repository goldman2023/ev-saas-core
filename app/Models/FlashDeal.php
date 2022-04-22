<?php

namespace App\Models;

use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\FlashDeal
 *
 * @property int $id
 * @property string|null $title
 * @property int|null $start_date
 * @property int|null $end_date
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\FlashDeal whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FlashDeal extends Model
{
    // use Cachable;
    use SoftDeletes;

    public function getTranslation($field = '', $lang = false)
    {
        $lang = $lang == false ? App::getLocale() : $lang;
        $flash_deal_translation = $this->hasMany(FlashDealTranslation::class)->where('lang', $lang)->first();

        return $flash_deal_translation != null ? $flash_deal_translation->$field : $this->$field;
    }

    public function business()
    {
        return $this->belongsTo(Shop::class, 'business_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'subject', 'flash_deal_relationships');
    }

    public function product_variations()
    {
        return $this->morphedByMany(ProductVariation::class, 'subject', 'flash_deal_relationships');
    }

    public function flash_deal_translations()
    {
        return $this->hasMany(FlashDealTranslation::class);
    }

    /*public function flashDealProducts()
    {
        return $this->hasMany(FlashDealProduct::class);
    }

    public function flash_deal_products()
    {
        return $this->hasMany(FlashDealProduct::class);
    }*/
}

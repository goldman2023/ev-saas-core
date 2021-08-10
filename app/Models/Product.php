<?php

namespace App\Models;

use App\Models\FlashDealProduct;
use App\Models\ProductTax;
use App\Models\User;
use App\Models\Wishlist;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use App\Traits\ReviewTrait;
use App;
/**
 * App\Models\Product
 *
 * @property int $id
 * @property string $name
 * @property string $added_by
 * @property int $user_id
 * @property int $category_id
 * @property int $brand_id
 * @property string|null $photos
 * @property string|null $thumbnail_img
 * @property string|null $featured_img
 * @property string|null $flash_deal_img
 * @property string|null $video_provider
 * @property string|null $video_link
 * @property string|null $tags
 * @property string|null $description
 * @property float $unit_price
 * @property float $purchase_price
 * @property string|null $choice_options
 * @property string|null $colors
 * @property string $variations
 * @property int $todays_deal
 * @property int $published
 * @property int $featured
 * @property int $current_stock
 * @property string|null $unit
 * @property float|null $discount
 * @property string|null $discount_type
 * @property float|null $tax
 * @property string|null $tax_type
 * @property string $shipping_type
 * @property float|null $shipping_cost
 * @property int $num_of_sale
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_img
 * @property string|null $pdf
 * @property string $slug
 * @property float $rating
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Brand $brand
 * @property-read \App\Models\Category $category
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereAddedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereChoiceOptions($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereColors($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereCurrentStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFeaturedImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereFlashDealImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMetaImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereNumOfSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePdf($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePhotos($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePublished($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product wherePurchasePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereShippingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereSubsubcategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTax($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTaxType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereThumbnailImg($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereTodaysDeal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereVariations($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereVideoLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Product whereVideoProvider($value)
 * @mixin \Eloquent
 */

class Product extends Model
{
    use ReviewTrait;

    protected $fillable = ['name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'unit', 'slug', 'colors', 'choice_options', 'current_stock', 'variations', 'num_of_sale', 'thumbnail_img'];

    protected $casts = [
        'choice_options' => 'object',
        'colors' => 'object',
        'attributes' => 'object'
    ];

    protected static function boot()
    {
        parent::boot();

        // Determine scope based on user role
        // If admin: select products that are both published and not published
        // If vendor/user: select products which are published
        if(!auth()->check() || (auth()->check() && auth()->user()->isCustomer())) {
            static::addGlobalScope('published', function (Builder $builder) {
                $builder->where('published', 1);
            });
        }
    }

    public function getTranslation($field = '', $lang = false) {
        $lang = $lang == false ? App::getLocale() : $lang;
        $product_translations = $this->hasMany(ProductTranslation::class)->where('lang', $lang)->first();
        return $product_translations != null ? $product_translations->$field : $this->$field;
    }

    public function product_translations() {
        return $this->hasMany(ProductTranslation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function stocks()
    {
        return $this->hasMany(ProductStock::class);
    }

    public function wishlists() {
        return $this->hasMany(Wishlist::class);
    }

    public function taxes() {
        return $this->hasMany(ProductTax::class);
    }

    public function flash_deal_product() {
        return $this->hasOne(FlashDealProduct::class);
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    // START: Casts section
    // If $value is null or empty, value should always be empty array!
    // Reason: Ease of use in frontend and backend views
    public function getColorsAttribute($value) {
        $atts = $this->castAttribute('attributes', $value);
        return empty($atts) ? [] : $atts;
    }
    public function getAttributesAttribute($value) {
        $colors = $this->castAttribute('colors', $value);
        return empty($colors) ? [] : $colors;
    }
    public function getChoiceOptionsAttribute($value) {
        $choice_options = $this->castAttribute('choice_options', $value);
        return empty($choice_options) ? [] : $choice_options;
    }
    // END: Casts section
}

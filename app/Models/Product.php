<?php

namespace App\Models;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\FlashDealProduct;
use App\Models\ProductTax;
use App\Models\User;
use App\Models\Wishlist;
use App\Traits\AttributeTrait;
use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ReviewTrait;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

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
    use AttributeTrait;
    use HasSlug;
    use SoftDeletes;

    /* Properties not saved in DB */
    public $temp_sku;
    public $current_stock;
    public $low_stock_qty;
    public $category_id; // TODO: This should be removed in future, once the code in admin is fixed in all places!


    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['stock'];


    protected $fillable = ['name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'unit', 'slug', 'colors', 'choice_options', 'num_of_sale', 'thumbnail_img', 'photos', 'temp_sku', 'current_stock', 'low_stock_qty'];

    protected $casts = [
        'choice_options' => 'object',
        'colors' => 'object',
        'attributes' => 'object',
    ];

    protected $appends = ['images', 'permalink','temp_sku', 'current_stock', 'low_stock_qty', 'category_id'];

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

        if(is_vendor_site()) {
            static::addGlobalScope('single_vendor', function (Builder $builder) {
                $builder->where('user_id', '=' , 6);
            });
        }

    }

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
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

    public function selected_categories($pluck_property = null, $is_collection = true) {
        $ids = $this->categories()->get()->pluck('id')->toArray();

        if($pluck_property) {
            $data = Category::tree()->get()->whereIn('id', $ids)->pluck($pluck_property);
        } else {
            $data = Category::tree()->get()->whereIn('id', $ids);
        }

        if(!$is_collection) {
            $data = $data->toArray();
        }

        return $data;
    }

    public function categories()
    {
        return $this->morphToMany(Category::class, 'subject', 'category_relationships', null, 'category_id');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function variations() {
        return $this->hasMany(ProductVariation::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function stock()
    {
        return $this->morphOne(ProductStock::class, 'subject');
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

    /**
     * Get all images related to the product but properly structured in an assoc. array
     * This function is used in frontend/themes etc.
     *
     * @return array*
     */
    public function getImagesAttribute() {
        $photos = [];
        $data = [
            'thumbnail' => [],
            'gallery' => []
        ];

        if(empty($this->attributes['photos'] ?? null) && empty($this->attributes['thumbnail_img'] ?? null)) {
            $data['thumbnail'] = [
                'id' => null,
                'url' => null
            ];
            return $data;
        }

        $photos_idx = explode(',', $this->attributes['photos']);
        foreach ($photos_idx as &$i) $i = (int) $i;


        if(!empty($this->attributes['thumbnail_img'])) {
            // Add thumb as the first element in photos array
            array_unshift($photos_idx, $this->attributes['thumbnail_img']);
        }

        if(!empty($photos_idx)) {
            $photos = get_images($photos_idx); // 1 SQL Query to rule them all...
        }

        if($photos) {
            foreach($photos as $photo) {
                $url = str_replace('tenancy/assets/', '', my_asset($photo->file_name)); /* TODO: This is temporary fix */

                if(config('imgproxy.enabled') == true) {
                    // TODO: Create an ImgProxyService class and Imgproxy facade to construct links with specific parameters and signature
                    // TODO: Put an Imgproxy server behind a CDN so it caches the images and offloads the server!
                    // TODO: Enable SSL on imgproxy server and add certificate for images.ev-saas.com subdomain
                    $url = config('imgproxy.host').'/insecure/fill/0/0/ce/0/plain/'.$url.'@webp'; // generate webp on the fly through imgproxy
                }

                if($photo->id ===  (int) $this->attributes['thumbnail_img']) {
                    $data['thumbnail'] = [
                        'id' => $photo->id,
                        'url' => $url
                    ];
                } else {
                    $data['gallery'][] = [
                        'id' => $photo->id,
                        'url' => $url
                    ];
                }
            }
        }

        return $data;
    }

    /* TODO: Implement product condition in backend: new/used/refurbished */
    public function getCondition() {
        return translate("New");
    }

    /**
     * Get the product permalink
     *
     * @return string $link
     */
    public function getPermalinkAttribute() {
        if(empty($this->attributes['slug'])) {
            return "#";
        }

        return route('product', $this->attributes['slug']);
    }

    public function setTempSkuAttribute($value)
    {
        $this->temp_sku = $value;
    }

    public function getTempSkuAttribute() {
        if(empty($this->temp_sku)) {
            $stock = $this->stock()->first();

            return $stock->sku ?? '';
        }

        return $this->temp_sku;
    }


    public function setCurrentStockAttribute($value) {
        $this->current_stock = $value;
    }

    public function getCurrentStockAttribute() {
        if(empty($this->current_stock)) {
            $stock = $this->stock()->first();

            return (float) ($stock->qty ?? 0);
        }

        return $this->current_stock;
    }

    public function setLowStockQtyAttribute($value) {
        $this->low_stock_qty = $value;
    }

    public function getLowStockQtyAttribute() {
        if(empty($this->low_stock_qty)) {
            $stock = $this->stock()->first();

            return (float) ($stock->low_stock_qty ?? 0);
        }

        return $this->low_stock_qty;
    }


    public function getCategoryIdAttribute() {
        if(empty($this->category_id)) {
            return $this->categories()->whereNull('parent_id')->first()->id ?? null;
        }

        return $this->category_id;
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

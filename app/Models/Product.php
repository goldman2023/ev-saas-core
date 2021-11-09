<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use Cache;
use App\Builders\ProductsBuilder;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Models\FlashDealProduct;
use App\Models\ProductTax;
use App\Models\User;
use App\Models\Wishlist;
use App\Traits\AttributeTrait;
use Auth;
use DB;
use IMG;
use Vendor;
use FX;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\ReviewTrait;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use App\Traits\PermalinkTrait;
use App\Traits\PriceTrait;
use App\Traits\StockManagementTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\Caching\SavesToCache;

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
 * @property int $todays_deal
 * @property int $published
 * @property int $featured
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
    use PermalinkTrait;
    use GalleryTrait;
    use ReviewTrait;
    use AttributeTrait;
    use HasSlug;
    use SoftDeletes;

    use StockManagementTrait;
    use PriceTrait;

    use RegeneratesCache;
    use SavesToCache;

    protected $table = 'products';

    /* Properties not saved in DB */
    public $category_id; // TODO: This should be removed in future, once the code in admin is fixed in all places!


    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['attributes', 'stock', 'flash_deals', 'variations', 'categories', 'brand', 'product_translations', 'serial_numbers', 'uploads'];


    protected $fillable = ['name', 'added_by', 'user_id', 'category_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'unit', 'slug', 'num_of_sale', 'thumbnail_img', 'photos'];

    protected $casts = [
        'colors' => 'object',
        'attributes' => 'object',
    ];

    protected $appends = ['images', 'category_id'];

    protected static function boot()
    {
        parent::boot();
    }

    /**
     * Replace Eloquent/Builder with ProductsBuilder (an extension of Eloquent/Builder with more features)
     *
     * @param    \Illuminate\Database\Query\Builder  $query
     * @return  App\Builders\ProductsBuilder
     */
    public function newEloquentBuilder($query)
    {
        return new ProductsBuilder($query);
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

    /**
     * Stream: Add extra activity data - task name, and user's display name:
     */
    public function activityExtraData()
    {
        return array('name'=>'$this->name', 'display_name' =>' $this->display_name');
    }

    /**
     * Stream: Change activity verb to 'created':
     */
    public function activityVerb()
    {
        return 'created';
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

    public function shop()
    {
        return $this->belongsTo(Shop::class);
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

    public function product_attributes()
    {
        $data = $this->morphToMany(Attribute::class, 'subject', 'attribute_relationships', null, 'attribute_id')
                ->get()->unique();

        // Eager load Attribute relationships for current product
        if(!empty($data)) {
            foreach($data as $key => $attribute) {
                $data[$key]->load(['attribute_relationships' => function ($query) {
                    $query->where([
                        ['subject_id', '=', $this->id],
                        ['subject_type', '=', Product::class]
                    ]);
                }]);
            }
        }

        return $data;
    }

    public function product_attributes_for_variations()
    {
        // TODO: Create AttributeObserver class and remove cache on any relationship or value change
        return Cache::get('product_'.$this->id.'_attributes_for_variations', function() {
            $data = $this->morphToMany(Attribute::class, 'subject', 'attribute_relationships', null, 'attribute_id')
                ->where('for_variations', '=', 1)->without(['attribute_relationships', 'attribute_values'])->get()->unique();

            // 1) Eager load Attribute relationships for current product and based on that, 2) eager load attribute values
            if(!empty($data)) {
                foreach($data as $key => $attribute) {
                    $data->put($key, $attribute->load(['attribute_relationships' => function ($query) {
                        $query->where([
                            ['subject_id', '=', $this->id],
                            ['subject_type', '=', Product::class]
                        ]);
                    }]));

                    $att_values_ids = $attribute->attribute_relationships->pluck('attribute_value_id');

                    $data->put($key, $attribute->load(['attribute_values' => function ($query) use ($att_values_ids) {
                        $query->whereIn('id', $att_values_ids);
                    }]));
                }
            }

            return $data;
        });
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

    public function serial_numbers()
    {
        return $this->morphMany(SerialNumber::class, 'subject');
    }

    public function wishlists() {
        return $this->hasMany(Wishlist::class);
    }

    public function taxes() {
        return $this->hasMany(ProductTax::class);
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

    /*
     * Get all Uploads related to the Model
     */
    public function uploads() {
        return $this->morphToMany(Upload::class, 'subject', 'uploads_content_relationships', 'upload_id')
            ->withPivot('type AS toc, group_id');
    }

    /* TODO: Implement product condition in backend: new/used/refurbished */
    public function getCondition() {
        return translate("New");
    }

    public function has_variations() {
        return $this->variations->isNotEmpty() ?? false;
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
    public function getAttributesAttribute($value) {
        $colors = $this->castAttribute('colors', $value);
        return empty($colors) ? [] : $colors;
    }
    // END: Casts section
}

<?php

namespace App\Models;

use DB;
use FX;
use App;
use IMG;
use Auth;
use Cache;
use Vendor;
use WEF;
use App\Models\User;
use App\Models\Wishlist;
use App\Traits\HasStatus;
use App\Traits\BrandTrait;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\ReviewTrait;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Traits\CategoryTrait;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Enums\ProductTypeEnum;
use App\Traits\AttributeTrait;
use App\Traits\PermalinkTrait;
use App\Traits\VariationTrait;
use App\Models\FlashDealProduct;
use App\Traits\HasContentColumn;
use App\Traits\TranslationTrait;
use App\Builders\ProductsBuilder;
use Spatie\Sluggable\SlugOptions;
use App\Traits\SocialReactionsTrait;
use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Caching\RegeneratesCache;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * App\Models\Product
 */

class Product extends WeBaseModel
{
    // use \Bkwld\Cloner\Cloneable;
    use HasSlug;
    use SoftDeletes;
    use RegeneratesCache;
    use PermalinkTrait;
    use HasStatus;
    use Purchasable;
    use ReviewTrait;
    use LogsActivity;
    use SocialReactionsTrait;
    use CoreMetaTrait;
    use HasContentColumn;

    use TranslationTrait;

    use AttributeTrait; // <-- This trait must be declared before VariationTrait!
    use CategoryTrait;
    use UploadTrait;
    use GalleryTrait;
    use PriceTrait;
    use StockManagementTrait;
    use VariationTrait; // <-- Should be after PriceTrait and StockManagementTrait

    use BrandTrait;

    protected $table = 'products';

    /**
     * The relationships that should always be loaded.
     * NOTE: Translation, Category, Upload, Attribute, Variation, Price and Brand traits are eager loading all relationships by default
     *
     * @var array
     */
    protected $cloneable_relations = ['variations', 'categories', 'uploads', 'brand', 'stock', 'flash_deals']; // TODO: Which core_met to clone???
    //public static $defaultEagerLoads = ['variations', 'categories', 'uploads', 'brand', 'stock', 'serial_numbers', 'flash_deals' ];

    protected $fillable = [
        'name', 'excerpt', 'added_by', 'user_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'base_currency', 'unit', 'slug', 'num_of_sales', 'meta_title', 'meta_description', 'shop_id'
    ];


    protected $casts = [
        'digital' => 'boolean',
        'use_serial' => 'boolean',
        'tags' => 'array',
        'unit_price' => 'float',
        'discount' => 'float',
    ];

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
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    /**
     * Get the route name for the model.
     *
     * @return string
     */
    public static function getRouteName()
    {
        return 'product.single';
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

    public static function getContentColumnName()
    {
        return 'description';
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query
                ->where('name', 'like', '%' . $term . '%')
                ->orWhere('excerpt', 'like', '%' . $term . '%')
                ->orWhere(self::getContentColumnName(), 'like', '%' . $term . '%')
        );
    }

    public function scopeNewest($query)
    {
        $query->orderBy('created_at', 'DESC');
    }
    public function scopePriceAsc($query)
    {
        $query->orderBy('unit_price', 'ASC');
    }
    public function scopeDiscountDesc($query)
    {
        $query->orderBy('discount', 'DESC');
    }
    public function scopeMostPopular($query)
    {
        return $query; // TODO: Ask Eim about views
    }

    public function scopeEvent($query)
    {
        $query->where('type', ProductTypeEnum::event()->value);
    }

    /**
     * Stream: Add extra activity data - task name, and user's display name:
     */
    public function activityExtraData()
    {
        return array('name' => '$this->name', 'display_name' => ' $this->display_name');
    }

    /**
     * Stream: Change activity verb to 'created':
     */
    public function activityVerb()
    {
        return 'created';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function wishlists()
    {
        return $this->morphMany(Wishlist::class, 'subject');
    }

    public function course_items() {
        return $this->hasMany(CourseItem::class);
    }

    public function product_addons() {
        $query = $this->morphToMany(ProductAddon::class, 'subject', 'product_addon_relationships')
            ->orWhere([
                ['product_addon_relationships.subject_id', '=', 0],
                ['product_addon_relationships.subject_type', '=', $this::class],
            ]);

        if($this->hasCategories()) {
            $query
                ->orWhere(function($query) {
                    $query->where('product_addon_relationships.subject_type', Category::class)
                        ->whereIn('product_addon_relationships.subject_id', $this->categories->pluck('id')->toArray());
                })
                ->orWhere([
                    ['product_addon_relationships.subject_id', '=', 0],
                    ['product_addon_relationships.subject_type', '=', Category::class],
                ]);
        }

        return $query->orderBy('product_addons.id', 'ASC')->groupBy('product_addons.id');
    }

    /* TODO: Implement product condition in backend: new/used/refurbished */
    public function getCondition()
    {
        return translate("New");
    }


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getPriceColumn()
    {
        return 'unit_price';
    }


    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'pdf', // This is the property name which we can use as $model->{property_name} to access desired Upload of the current Model
                'relation_type' => 'pdf', // This is an identificator which determines the relation between Upload and Model (e.g. Products have `thumbnail`, `cover`, `gallery`, `meta_img`, `pdf`, `documents` etc.; Blog posts have `thumbnail`, `cover`, `gallery`, `meta_img`, `documents` etc.).
                'multiple' => false // Property getter function logic and return type (Upload or (Collection/array)) depend on this parameter. Default: false!
            ]
        ];
    }

    /* TODO: @vukasin Implement checkbox in product.create for enabling units display, by default it's disabled */
    function showUnits($show = false) {
        return $show;
    }

    function public_view_count($period = 'all')
    {

        $ttl = 600;
        $product = $this;
        if ($period == 'all') {
            $view_count = Cache::remember('product_view_count_' . $this->id . '_' . $period, $ttl, function () use ($product) {
                return \Spatie\Activitylog\Models\Activity::where('subject_id', $product->id)
                    ->whereJsonContains('properties->action', 'viewed')
                    ->orderBy(
                        'created_at',
                        'desc'
                    )->count();
            });
        }

        return $view_count;
    }


    public function getVariationModelClass()
    {
        return [
            'class' => ProductVariation::class,
            'foreign_key' => 'product_id'
        ];
    }

    public function isBookableService() {
        return $this->type === ProductTypeEnum::bookable_service()->value && !empty($this->getBookingLink());
    }

    public function isEvent() {
        return $this->type === ProductTypeEnum::event()->value;
    }

    public function isCourse() {
        return $this->type === ProductTypeEnum::course()->value;
    }

    public function isStandard() {
        return $this->type === ProductTypeEnum::standard()->value;
    }

    public function isSubscription() {
        return $this->type === ProductTypeEnum::subscription()->value;
    }

    public function isPhysicalSubscription() {
        return $this->type === ProductTypeEnum::physical_subscription()->value;
    }

    public function getBookingLink() {
        return $this->core_meta?->where('key', 'calendly_link')->first()?->value ?? null;
    }

    public function comments() {
        return $this->morphMany(SocialComment::class, 'subject');
    }

    public function relatedProducts($count = 4) {
       $products = Product::take($count)->get();

       return $products;
    }

    public function getWEFDataTypes() {
        // Bunch of stuff from here should go to dynamic WEF for specific project/theme/tenant...
        return WEF::bundleWithGlobalWEF(apply_filters('product.wef.data-types', [
            'date_type' => 'string',
            'start_date' => 'date',
            'end_date' => 'date',
            'location_type' => 'string',
            'location_address' => 'string',
            'location_address_map_link' => 'string',
            'location_link' => 'string',
            'unlockables' => 'string', // for now it's a string/wysiwyg
            'unlockables_structure' => 'array',
            'calendly_link' => 'string',

            // Course core_meta
            'course_what_you_will_learn' => 'array',
            'course_requirements' => 'array',
            'course_target_audience' => 'array',
            'course_includes' => 'array',
            'course_intro_video_url' => 'string',

            // 'custom_cta_title' => 'string',
            'thank_you_cta_custom_title' => 'string',
            'thank_you_cta_custom_text' => 'string',
            'thank_you_cta_custom_url' => 'string',
            'thank_you_cta_custom_button_title' => 'string',
        ]));
    }

}

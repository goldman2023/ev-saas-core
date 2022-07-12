<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use App\Traits\BrandTrait;
use App\Traits\CategoryTrait;
use App\Traits\GalleryTrait;
use App\Traits\Purchasable;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use App\Traits\VariationTrait;
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
use App\Traits\HasStatus;
use App\Traits\CoreMetaTrait;
use App\Traits\SocialReactionsTrait;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product
 */

class Product extends WeBaseModel
{
    use \Bkwld\Cloner\Cloneable;
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
    protected $cloneable_relations = ['translations', 'variations', 'categories', 'uploads', 'brand', 'stock', 'flash_deals']; // TODO: Which core_met to clone???
    //public static $defaultEagerLoads = ['variations', 'categories', 'uploads', 'brand', 'stock', 'serial_numbers', 'flash_deals' ];

    protected $fillable = [
        'name', 'description', 'excerpt', 'added_by', 'user_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'base_currency', 'unit', 'slug', 'num_of_sales', 'meta_title', 'meta_description', 'shop_id'
    ];


    protected $casts = [
        'digital' => 'boolean',
        'use_serial' => 'boolean',
        'tags' => 'array',
        'unit_price' => 'float',
        'discount' => 'float',
    ];

    public function getBaseCurrencyAttribute($value)
    {
        if (empty($value)) {
            $value =  get_setting('system_default_currency')->code;
        }

        return $value;
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

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query
                ->where('name', 'like', '%' . $term . '%')
                ->orWhere('excerpt', 'like', '%' . $term . '%')
                ->orWhere('description', 'like', '%' . $term . '%')
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

    public function taxes()
    {
        return $this->hasMany(ProductTax::class);
    }

    public function course_items() {
        return $this->hasMany(CourseItem::class);
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


    public function getTranslationModel(): ?string
    {
        return ProductTranslation::class;
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

}

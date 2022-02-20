<?php

namespace App\Models;

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
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * App\Models\Product
 */

class Product extends EVBaseModel
{
    use HasSlug;
    use SoftDeletes;
    use RegeneratesCache;

    use TranslationTrait;
    use PermalinkTrait;
    use AttributeTrait;
    use CategoryTrait;

    use UploadTrait;
    use GalleryTrait;
    use BrandTrait;
    use StockManagementTrait;
    use PriceTrait;
    use Purchasable;

    use ReviewTrait;

    use VariationTrait;

    use LogsActivity;


    public const ROUTING_SINGULAR_NAME_PREFIX = 'product';
    public const ROUTING_PLURAL_NAME_PREFIX = 'products';

    protected $table = 'products';

    /**
     * The relationships that should always be loaded.
     * NOTE: Translation, Category, Upload, Attribute, Variation, Price and Brand traits are eager loading all relationships by default
     *
     * @var array
     */
    protected $with = ['variations'];
    //public static $defaultEagerLoads = ['variations', 'categories', 'uploads', 'brand', 'stock', 'serial_numbers', 'flash_deals' ];

    protected $fillable = ['name', 'description', 'excerpt', 'added_by', 'user_id', 'brand_id', 'video_provider', 'video_link', 'unit_price',
        'purchase_price', 'base_currency', 'unit', 'slug', 'num_of_sales', 'meta_title', 'meta_description', 'shop_id'];


    protected $casts = [
        'digital' => 'boolean',
        'tags' => 'array'
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
    public function getSlugOptions() : SlugOptions
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
    public static function getRouteName() {
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
                ->where('name', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere('description', 'like', '%'.$term.'%')
        );
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

    public function taxes() {
        return $this->hasMany(ProductTax::class);
    }

    /* TODO: Implement product condition in backend: new/used/refurbished */
    public function getCondition() {
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

    public function getLikesCount() {
        return $this->likes()->count();
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

    function public_view_count() {

        $ttl = 600;
        $product = $this;
        $view_count = Cache::remember('product_view_count_' . $this->id, $ttl, function () use ($product) {
            return \Spatie\Activitylog\Models\Activity::where('subject_id', $product->id)
            ->whereJsonContains('properties->action', 'viewed')
            ->orderBy('created_at','desc'
            )->count();
        });

        return $view_count;
    }


    public function getVariationModelClass()
    {
        return [
            'class' => ProductVariation::class,
            'foreign_key' => 'product_id'
        ];
    }

    public function main()
    {
        return null;
    }
}

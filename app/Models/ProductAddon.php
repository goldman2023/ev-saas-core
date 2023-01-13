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
use App\Traits\HasStatus;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Builders\BaseBuilder;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Traits\PermalinkTrait;
use Spatie\Sluggable\SlugOptions;
use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

/**
 * App\Models\ProductAddon
 */

class ProductAddon extends WeBaseModel
{
    use \Bkwld\Cloner\Cloneable;
    use HasSlug;
    use SoftDeletes;
    use PermalinkTrait;
    use HasStatus;
    use Purchasable;
    use LogsActivity;
    use CoreMetaTrait;

    use UploadTrait;
    use GalleryTrait;
    use PriceTrait;
    use StockManagementTrait;

    protected $table = 'product_addons';

    protected $fillable = [
        'name', 'description', 'excerpt', 'user_id', 'unit_price', 'discount', 'discount_type', 'status',
        'base_currency', 'unit', 'slug', 'meta_title', 'meta_description', 'shop_id'
    ];


    protected $casts = [
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
        return new BaseBuilder($query);
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
        return 'product.addon.single';
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

    public function getPriceColumn()
    {
        return 'unit_price';
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }


    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
        // return [
        //     [
        //         'property_name' => 'pdf', // This is the property name which we can use as $model->{property_name} to access desired Upload of the current Model
        //         'relation_type' => 'pdf', // This is an identificator which determines the relation between Upload and Model (e.g. Products have `thumbnail`, `cover`, `gallery`, `meta_img`, `pdf`, `documents` etc.; Blog posts have `thumbnail`, `cover`, `gallery`, `meta_img`, `documents` etc.).
        //         'multiple' => false // Property getter function logic and return type (Upload or (Collection/array)) depend on this parameter. Default: false!
        //     ]
        // ];
    }

    /* TODO: @vukasin Implement checkbox in product.create for enabling units display, by default it's disabled */
    function showUnits($show = false) {
        return $show;
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('product-addon.wef.data-types', []));
    }

}

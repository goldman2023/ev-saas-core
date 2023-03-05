<?php

namespace App\Models;

use DB;
use FX;
use App;
use IMG;
use WEF;
use Auth;
use Cache;
use Vendor;
use App\Models\User;
use App\Models\Category;
use App\Traits\HasStatus;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\UploadTrait;
use App\Traits\GalleryTrait;
use App\Builders\BaseBuilder;
use App\Traits\CategoryTrait;
use App\Traits\CoreMetaTrait;
use Spatie\Sluggable\HasSlug;
use App\Traits\AttributeTrait;
use App\Traits\PermalinkTrait;
use App\Traits\VariationTrait;
use App\Traits\HasContentColumn;
use Spatie\Sluggable\SlugOptions;
use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use App\Support\Eloquent\Relations\AllFromModelRelation;

/**
 * App\Models\ProductAddon
 */

class ProductAddon extends WeBaseModel
{
    // use \Bkwld\Cloner\Cloneable;
    use HasSlug;
    use SoftDeletes;
    use PermalinkTrait;
    use HasStatus;
    use Purchasable;
    use LogsActivity;
    use CoreMetaTrait;
    use HasContentColumn;

    use AttributeTrait; // <-- This trait must be declared before VariationTrait!
    use CategoryTrait;
    use UploadTrait;
    use GalleryTrait;
    use PriceTrait;
    use StockManagementTrait;
    use VariationTrait; // <-- Should be after PriceTrait and StockManagementTrait

    protected $table = 'product_addons';

    protected $fillable = [
        'name', 'description', 'excerpt', 'user_id', 'unit_price', 'discount', 'discount_type', 'status', 'type',
        'base_currency', 'unit', 'slug', 'meta_title', 'meta_description', 'shop_id'
    ];


    protected $casts = [
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

    public static function getContentColumnName()
    {
        return 'description';
    }

    public function getVariationModelClass() {
        return null;
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where(function($query) use($term) {
                $query
                    ->where('name', 'like', '%' . $term . '%')
                    ->orWhere('excerpt', 'like', '%' . $term . '%')
                    ->orWhere('description', 'like', '%' . $term . '%');
            })
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
    
    /**
     * Products relationship
     *
     * @param  mixed $return_real - If this is true, AllFromModelRelation will return fake model with id = 0. Otherwise, it'll return all related models.
     * @return void
     */
    public function products($return_real = false) {
        // Check if All is present -> subject_id = 0
        $check_for_all = DB::scalar(
            "select count(case when subject_id = 0 and product_addon_id = ".($this->id ?? 0)." and subject_type = '".addslashes(Product::class)."' then 1 end) as products from product_addon_relationships"
        );

        if($check_for_all > 0) {
            // This means that relation to all is present in DB
            return new AllFromModelRelation(Product::class, ['published'], return_real: $return_real);
        } else {
            return $this->morphedByMany(Product::class, 'subject', 'product_addon_relationships');
        }
    }
    
    /**
     * products_morph
     *
     * This is a relation where relation-functions should be performed!
     * 
     * @return void
     */
    public function products_morph() {
        return $this->morphedByMany(Product::class, 'subject', 'product_addon_relationships');
    }

    /**
     * Products relationship
     *
     * @param  mixed $return_real - If this is true, AllFromModelRelation will return fake model with id = 0. Otherwise, it'll return all related models.
     * @return void
     */
    public function category_taxonomy($return_real = false) {
        $check_for_all = DB::scalar(
            "select count(case when subject_id = 0 and product_addon_id = ".($this->id ?? 0)." and subject_type = '".addslashes(Category::class)."' then 1 end) as products from product_addon_relationships"
        );

        if($check_for_all > 0) {
            // This means that relation to all is present in DB
            return new AllFromModelRelation(Category::class, [], return_real: $return_real);
        } else {
            return $this->morphedByMany(Category::class, 'subject', 'product_addon_relationships');
        }
    }

    /**
     * category_taxonomy_morph
     *
     * This is a relation where relation-functions should be performed!
     * 
     * @return void
     */
    public function category_taxonomy_morph() {
        return $this->morphedByMany(Category::class, 'subject', 'product_addon_relationships');
    }

    protected function asJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    /* TODO: @vukasin Implement checkbox in product.create for enabling units display, by default it's disabled */
    function showUnits($show = false) {
        return $show;
    }

    public function getWEFDataTypes() {
        return WEF::bundleWithGlobalWEF(apply_filters('product-addon.wef.data-types', [
            
        ]));
    }

}

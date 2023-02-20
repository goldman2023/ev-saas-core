<?php

namespace App\Models;

use App;
use Str;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\ReviewTrait;
use App\Traits\UploadTrait;
use App\Models\ProductAddon;
use App\Traits\GalleryTrait;
use Spatie\Sluggable\HasSlug;
use App\Models\Central\Tenant;
use App\Traits\AttributeTrait;
use App\Traits\PermalinkTrait;
use App\Traits\VariationTrait;
use App\Traits\IsVariationTrait;
use App\Traits\Caching\SavesToCache;
use App\Traits\StockManagementTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Caching\RegeneratesCache;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Events\Products\ProductVariationDeleting;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Casts\Attribute as AttributeCast;

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
 * @mixin \Eloquentf
 */

class ProductVariation extends WeBaseModel
{
    use Notifiable;
    use SoftDeletes;


    use UploadTrait;
    use GalleryTrait;

    use StockManagementTrait;
    use PriceTrait;
    use Purchasable;

    use ReviewTrait;

    use IsVariationTrait;


    // Default atts
    protected $attributes = [
        'price' => 0,
        'discount' => 0,
    ];

    /**
     * The relationships that should always be loaded.
     * NOTE: Uploads, Attribute, Price and Stock traits are eager loading all relationships by default
     *
     * @var array
     */
    protected $with = [];

    protected $fillable = ['product_id', 'variant', 'price', 'discount', 'discount_type', 'created_at', 'updated_at'];
    //protected $visible = ['id', 'product_id', 'variant', 'image', 'image_url', 'price', 'discount', 'discount_type', 'name'];

    protected $casts = [
        'variant' => 'array',
    ];

    // IMPORTANT: main is now a core property and is injected when model eager-loads it's variations.
    // Reason for this is that main() relationship ends up in recursive loop for some reason even though all scopes and eager-loads are disabled...so we cannot use it.
    // We must rely on injecting the parent model manually to each variation (which also reduces the number of queries)

    // public function main()
    // {
    //     //dd($this->belongsTo(Product::class, 'product_id', 'id')->without(Product::$defaultEagerLoads)->first());
    //     return $this->belongsTo(Product::class, 'product_id', 'id')->withoutGlobalScopes()->setEagerLoads([]);
    // }

    /**
     * Returns column name of the price
     *
     * @return string
     */
    public function getPriceColumn(): string
    {
        return 'price';
    }

    public function product_addons() {
        // TODO: Add support for addons which have All and for addons added to categories!
        return $this->morphToMany(ProductAddon::class, 'subject', 'product_addon_relationships');
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }
}

<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Traits\AttributeTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\CategoryTrait;
use App\Traits\GalleryTrait;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use MyShop;

class Plan extends EVBaseModel
{
    use HasSlug;
    use SoftDeletes;
    use RegeneratesCache;
    use Purchasable;
    use PriceTrait;
    use CategoryTrait;
    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;
    use TranslationTrait;

    protected $table = 'plans';

    protected $fillable = ['title', 'excerpt', 'content', 'status', 'features', 'price', 'discount', 'discount_type', 'tax', 'tax_type', 'meta_title', 'meta_description', 'meta_keywords'];

    protected $casts = [
        'features' => 'array',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected static function booted()
    {
        // TODO: Fix to show all plans in Frontend and only my posts in Backend
        // Show only MyShop Suscription Plans
        static::addGlobalScope('from_my_shop', function (BaseBuilder $builder) {
            $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1);
        });
    }


    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getPriceColumn()
    {
        return 'price';
    }

    public function getTranslationModel(): ?string
    {
        return PlanTranslation::class;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query->where('id', 'like', '%'.$term.'%')
                ->orWhere('title', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere('content', 'like', '%'.$term.'%')
        );
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function getFeaturesAttribute($value) {
        if(empty($value)) {
            return [''];
        }

        return is_array($value) ? $value : json_decode($value, true);
    }
}

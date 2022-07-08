<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Enums\StatusEnum;
use App\Traits\AttributeTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\CategoryTrait;
use App\Traits\CoreMetaTrait;
use App\Traits\GalleryTrait;
use App\Traits\HasStatus;
use App\Traits\PermalinkTrait;
use App\Traits\PriceTrait;
use App\Traits\Purchasable;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use App\Traits\VariationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use MyShop;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Plan extends WeBaseModel
{
    use HasSlug;
    use SoftDeletes;
    use RegeneratesCache;
    use Purchasable;
    use PermalinkTrait;
    use PriceTrait;
    use CategoryTrait;
    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;
    use TranslationTrait;
    use CoreMetaTrait;
    use HasStatus;

    protected $table = 'plans';

    protected $fillable = ['name', 'featured', 'primary', 'non_standard', 'excerpt', 'content', 'status', 'features', 'price', 'discount', 'discount_type', 'yearly_discount', 'yearly_discount_type', 'tax', 'tax_type', 'meta_title', 'meta_description', 'meta_keywords'];
    // protected $cloneable_relations = ['translations', 'variations', 'categories', 'uploads', 'brand', 'stock', 'flash_deals', 'core_meta'];

    protected $casts = [
        'features' => 'array',
        'featured' => 'boolean',
        'primary' => 'boolean',
        'non_standard' => 'boolean',
        'created_at' => 'datetime:d.m.Y H:i',
        'updated_at' => 'datetime:d.m.Y H:i',
    ];

    protected static function booted()
    {
        // TODO: Fix to show all plans in Frontend and only my posts in Backend
        // Show only MyShop Suscription Plans
        static::addGlobalScope('from_my_shop', function (BaseBuilder $builder) {
            if (request()->route()->getName() == 'my.plans.management') {
                $builder->where('shop_id', '=', 1);
            } else {
                if (request()->is_dashboard) {
                    $builder->where('shop_id', '=', 1);
                    // $builder->where('shop_id', '=', MyShop::getShop()->id ?? -1);
                }
            }
        });
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public static function getRouteName()
    {
        return 'plan.single';
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
                ->orWhere('name', 'like', '%'.$term.'%')
                ->orWhere('excerpt', 'like', '%'.$term.'%')
                ->orWhere('content', 'like', '%'.$term.'%')
        );
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subscribers()
    {
        return $this->morphToMany(User::class, 'subject', 'user_subscriptions');
    }

    public function blog_posts()
    {
        return $this->morphToMany(BlogPost::class, 'subject', 'blog_post_relationships');
    }

    public function hasSubscribers()
    {
        return $this->subscribers()->count() > 0;
    }

    public function getFeaturesAttribute($value)
    {
        if (empty($value)) {
            return [''];
        }

        return is_array($value) ? $value : json_decode($value, true);
    }

    public function main()
    {
        return null;
    }

    public function getVariationModelClass()
    {
        return null;
    }
}

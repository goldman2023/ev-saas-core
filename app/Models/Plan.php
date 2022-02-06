<?php

namespace App\Models;

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
}

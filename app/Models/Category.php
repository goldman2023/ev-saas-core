<?php

namespace App\Models;

use App\Builders\BaseBuilder;
use App\Builders\CteBuilder;
use App\Facades\Categories;
use App\Traits\GalleryTrait;
use App\Traits\TranslationTrait;
use App\Traits\UploadTrait;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Str;
use Vendor;

/**
 * App\Models\Category
 */

class Category extends EVBaseModel
{
    //use Cachable;
    use HasSlug;
    use HasRecursiveRelationships;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;

    use TranslationTrait;
    use UploadTrait;
    use GalleryTrait;

    public $selected;
    public $title_path;
    public const PATH_SEPARATOR = '.';

    protected $fillable = ['id', 'parent_id', 'level', 'name', 'slug', 'description', 'featured', 'top', 'digital', 'meta_description', 'meta_title'];
    protected $appends = ['selected', 'title_path'];

    protected $casts = [
        'created_at' => 'date:d.m.Y',
        'featured' => 'boolean',
        'digital' => 'boolean',
        'top' => 'boolean',
    ];

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('d.m.Y');
    }

    /**
     * Create a new Eloquent query builder for the model.
     *
     * @param \Illuminate\Database\Query\Builder $query
     * @return CteBuilder|static
     */
    public function newEloquentBuilder($query)
    {
        return new CteBuilder($query);
    }

    public function getParentKeyName() {
        return 'parent_id';
    }

    public function getLocalKeyName() {
        return 'id';
    }

    public function getPathName()
    {
        return 'path';
    }

    public function getPathSeparator()
    {
        return '.';
    }

    public function getCustomPaths() {
        return [
            [
                'name' => 'slug_path',
                'column' => 'slug',
                'separator' => self::PATH_SEPARATOR,
            ],
        ];
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

    protected static function booted()
    {
        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'ASC');
        });

        if (Vendor::isVendorSite()) {
            // If Vendor Site, add global scope to restrict categories by categories in which vendor actually has any models
            static::addGlobalScope('single_vendor', function (Builder $builder) {
                if(!empty(Vendor::getVendorCategoriesIDs())) {
                    $builder->whereIn('categories.id', Vendor::getVendorCategoriesIDs());
                }
            });
        }
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%'.$term.'%');
    }

    // TODO: FIX THIS TOO. REMOVE CLASSIFIED PRODUCTS!
//    public function classified_products(){
//    	return $this->hasMany(CustomerProduct::class);
//    }

    public function categories()
    {
        return $this->hasManyOfDescendantsAndSelf(self::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'subject', 'category_relationships');
    }

    public function shops()
    {
        return $this->morphedByMany(Shop::class, 'subject', 'category_relationships');
    }

    // TODO: Create Category groups. Each category group is related to specific content types.
    // TODO: Get rid of unnecessary categories tables in DB, like: blog_categories, home_categories.
    // TODO: Make sure in future we only use following tables: categories, category_translations, category_relationships, category_groups (not created), category_group_relationships (not created)
//    public function news()
//    {
//        return $this->belongsTo(Blog::class, 'category_id');
//    }

    public function setSelectedAttribute($value) {
        $this->selected = $value;
    }

    public function getSelectedAttribute() {
        return $this->selected ?? false;
    }

    public function getTitlePathAttribute() {
        $title_path = explode(self::PATH_SEPARATOR, $this->slug_path);

        if(count($title_path) > 1) {
            foreach($title_path as $key => $title) {
                $title_path[$key] = trim(Str::title(str_replace('-', ' ', $title)));
            }
        }

        return implode(' '.self::PATH_SEPARATOR.' ', $title_path);
    }

    public function getPermalink($content_type = null)
    {
        return Categories::getRoute($this, $content_type);
    }

    public function getTranslationModel(): ?string
    {
        return CategoryTranslation::class;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [
            [
                'property_name' => 'icon',
                'relation_type' => 'icon',
                'multiple' => false
            ]
        ];
    }
}

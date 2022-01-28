<?php

namespace App\Models;

use App\Facades\Categories;
use App\Traits\TranslationTrait;
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
 *
 * @property int $id
 * @property string $name
 * @property string|null $banner
 * @property string|null $icon
 * @property int $featured
 * @property int $top
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Product[] $products
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereBanner($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereTop($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */

class Category extends EVBaseModel
{
    //use Cachable;
    use HasSlug;
    use HasRecursiveRelationships;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;

    use TranslationTrait;

    public $selected;
    public $title_path;
    public const PATH_SEPARATOR = '.';

    protected $appends = ['selected', 'title_path'];

    protected $with = ['translations'];

    protected $casts = [
        'created_at' => 'date:d.m.Y'
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

    protected static function boot()
    {
        parent::boot();

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
    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

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
    public function news()
    {
        return $this->belongsTo(Blog::class, 'category_id');
    }

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

    public function getPermalinkAttribute()
    {
        return Categories::getRoute($this);
    }

    public function getTranslationModel(): ?string
    {
        return CategoryTranslation::class;
    }
}

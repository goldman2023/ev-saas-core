<?php

namespace App\Models;

use App\Builders\CteBuilder;
use App\Traits\GalleryTrait;
use App\Traits\UploadTrait;
use App\Traits\PermalinkTrait;
use DateTimeInterface;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
use Str;

/**
 * App\Models\CourseItem
 */

class CourseItem extends WeBaseModel
{
    //use Cachable;
    use HasSlug;
    use HasRecursiveRelationships;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;
    use UploadTrait;
    use GalleryTrait;
    use PermalinkTrait;
    use LogsActivity;

    public $selected;
    public $title_path;
    public const PATH_SEPARATOR = '.';

    protected $fillable = ['id', 'parent_id', 'product_id', 'type', 'subject_id', 'subject_type', 'free', 'name', 'slug', 'excerpt', 'video', 'content', 'order', 'accessible_after', 'meta_description', 'meta_title'];
    protected $appends = ['selected', 'title_path'];

    protected $casts = [
        'free' => 'boolean',
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

    public function getDepthName() {
        return 'depth';
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
            ->saveSlugsTo('slug')
            ->doNotGenerateSlugsOnUpdate();
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

    /**
     * Get the route name for the model.
     *
     * @return string
     */
    public static function getRouteName()
    {
        return 'course.item.single';
    }

    protected static function booted()
    {
        // static::addGlobalScope('alphabetical', function (Builder $builder) {
        //     $builder->orderBy('name', 'ASC');
        // });

        // try {
        //     if (Vendor::isVendorSite()) {
        //         // If Vendor Site, add global scope to restrict categories by categories in which vendor actually has any models
        //         static::addGlobalScope('single_vendor', function (Builder $builder) {
        //             if(!empty(Vendor::getVendorCategoriesIDs())) {
        //                 $builder->whereIn('categories.id', Vendor::getVendorCategoriesIDs());
        //             }
        //         });
        //     }
        // } catch(\Throwable $e) {
        //     // reason for this try/catch is actually EventServiceProvider which registers Observers before WeServiceProvider boot() method is loaded
        //     // Observers are loaded for Category class with method Category::observe() which has to run booted method of Category (current function), and this happens before Vendor facade is properly initated, hence the error!
        // }

    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where('name', 'like', '%'.$term.'%')
                    ->orWhere('excerpt', 'like', '%'.$term.'%')
                    ->orWhere('content', 'like', '%'.$term.'%');
    }

    public function course_items()
    {
        return $this->hasManyOfDescendantsAndSelf(self::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function subject()
    {
        return $this->morphTo();
    }

    public function comments() {
        return $this->morphMany(SocialComment::class, 'subject');
    }

    public function setSelectedAttribute($value) {
        $this->selected = $value;
    }

    public function getSelectedAttribute() {
        return $this->selected ?? false;
    }

    public function getTitlePathAttribute($value) {
        $title_path = explode(self::PATH_SEPARATOR, $this->slug_path);

        if(count($title_path) > 1) {
            foreach($title_path as $key => $title) {
                $title_path[$key] = trim(Str::title(str_replace('-', ' ', $title)));
            }
        }

        return implode(' '.self::PATH_SEPARATOR.' ', $title_path);
    }

    public function setTitlePathAttribute($value)
    {
        $this->title_path= $value;
    }



    public function getDynamicModelUploadProperties(): array
    {
        return [

        ];
    }
}

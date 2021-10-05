<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

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

class Category extends Model
{
    //use Cachable;
    use HasRecursiveRelationships;
    use \Staudenmeir\LaravelCte\Eloquent\QueriesExpressions;

    public $selected;

    protected $appends = ['selected'];

    public function getParentKeyName() {
        return 'parent_id';
    }

    public function getLocalKeyName() {
        return 'id';
    }

    public function getCustomPaths() {
        return [
            [
                'name' => 'slug_path',
                'column' => 'slug',
                'separator' => '.',
            ],
        ];
    }

    public function getTranslation($field = '', $lang = false){
        $lang = $lang == false ? App::getLocale() : $lang;
        $category_translation = $this->hasMany(CategoryTranslation::class)->where('lang', $lang)->first();
        return $category_translation != null ? $category_translation->$field : $this->$field;
    }

    public function category_translations(){
    	return $this->hasMany(CategoryTranslation::class);
    }

    public function classified_products(){
    	return $this->hasMany(CustomerProduct::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'ASC');
        });


        static::addGlobalScope('alphabetical', function (Builder $builder) {
            $builder->orderBy('name', 'ASC');
        });
    }


    public function categories()
    {
        return $this->hasManyOfDescendantsAndSelf('App\Models\Category');
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'subject', 'category_relationships');
    }

    public function companies()
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

}

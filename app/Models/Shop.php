<?php

namespace App\Models;

use App\Models\User;
use App\Traits\AttributeTrait;
use App\Traits\Caching\RegeneratesCache;
use App\Traits\GalleryTrait;
use App\Traits\ReviewTrait;
use App\Traits\UploadTrait;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PermalinkTrait;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * App\Models\Shop
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $logo
 * @property string|null $sliders
 * @property string|null $address
 * @property string|null $facebook
 * @property string|null $google
 * @property string|null $twitter
 * @property string|null $youtube
 * @property string|null $instagram
 * @property string|null $slug
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereSliders($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Shop whereYoutube($value)
 * @mixin \Eloquent
 */

class Shop extends EVBaseModel
{
    use HasSlug;
    use RegeneratesCache;

    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;
    use ReviewTrait;
    use PermalinkTrait;

    protected $table = 'shops';

    protected $fillable = ['name', 'slug', 'excerpt', 'content', 'meta_title', 'meta_description'];

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
     * Get the route name for the model.
     *
     * @return string
     */
    public static function getRouteName() {
        return 'shop.single';
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

    public function users()
    {
        return $this->morphToMany(User::class, 'subject', 'user_relationships');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'company_category');
    }

    public function settings()
    {
        return $this->hasMany(ShopSetting::class);
    }

    public function addresses()
    {
        return $this->hasMany(ShopAddress::class);
    }

    public function domains()
    {
        return $this->hasMany(ShopDomain::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function blog_posts() {
        return $this->hasMany(BlogPost::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class, 'business_id', 'id');
    }

    public function payment_methods_universal()
    {
        return $this->belongsToMany(PaymentMethodUniversal::class, 'payment_methods_universal_relationships', 'shop_id', 'upm_id')
            ->withPivot('enabled');
    }

    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class, 'shop_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'shop_id');
    }

    public function getPhonesAttribute($value) {
        if(empty($value)) {
            return [''];
        }

        return is_array($value) ? $value : json_decode($value, true);
    }


    public function get_company_logo()
    {

        if ($this->logo) {
            $logo = uploaded_asset($this->logo);
        } else {
            $logo = "https://socialistmodernism.com/wp-content/uploads/2017/07/placeholder-image.png";
        }

        return $logo;
    }

    public function get_company_cover()
    {

        if ($this->sliders) {
            $logo = uploaded_asset($this->sliders);
        } else {
            $logo = "https://images.unsplash.com/photo-1476231682828-37e571bc172f?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=967&q=80";
        }

        return $logo;
    }

    public function company_has_logo()
    {
        if ($this->logo) {
            return true;
        }

        return false;
    }

    public function isVerified()
    {

        /* TODO: Add dynamic verification column to shops table */
        $verification_status = true;

        if ($verification_status === true) {
            return true;
        } else {
            return false;
        }
    }

    /* Function to return integer value for company public rating
    TODO: How this is calculated we will implement when we have reviewable trait
    */

    public function getPublicRating()
    {
        /* Return a value between 0 - 5 */
        return 5;
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [

        ];
    }

    public function followers() {
        return $this->morphToMany(User::class, 'subject', 'wishlists');
        // return Wishlist::where('subject_type', 'App\Models\User')->where('subject_id', $this->id);
    }
}

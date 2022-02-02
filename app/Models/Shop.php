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
    use RegeneratesCache;

    use AttributeTrait;
    use UploadTrait;
    use GalleryTrait;
    use ReviewTrait;

    protected $table = 'shops';

    protected $fillable = ['name', 'slug', 'excerpt', 'content', 'meta_title', 'meta_description'];

    public function seller()
    {
        $seller = Seller::where('user_id', $this->morphToMany(User::class, 'subject', 'user_relationships')->get()->first(fn($value, $key) => $value->user_type === 'seller')->id ?? null)->first();

        return !empty($seller->id ?? null) ? $seller : null;
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

    public static function companies_count_rounded()
    {
        $total = 0;

        $companies = Shop::all()->count();

        /* Round to closest 100 */
        $total = ceil($companies / 100) * 100;

        return $total;
    }

    public function get_company_website_url()
    {
        $website = [];
        $website_attribute = $this->user->seller->get_attribute_value_by_id(40);

        $website['href'] = $website_attribute;

        return $website;
    }

    public function getPermalinkAttribute() {
        /* TODO: Make this consistent with naming convention
        Overiding for custom route names */
        return route('shop.visit', $this->slug);
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

    public function company_size_calculated()
    {
        /* Size goes 1/5 */
        $size = 1;

        $turnover = $this->user->seller->get_attribute_value_by_id(35);
        /* Micro company Size */
        if ($turnover < 2000000) {
            $size = 1;
        } else if ($turnover < 12000000) {
            $size = 2;
        } else if ($turnover < 60000000) {
            $size = 3;
        } else if ($turnover < 1000000000) {
            $size = 4;
        } else {
            $size = 5;
        }

        return $size;
    }



    public function company_has_description()
    {
        if ($this->meta_description) {
            return true;
        } else {
            return false;
        }
    }


    public function company_has_required_attributes()
    {
        $attributeCount = $this->user->seller->custom_attributes()
            ->count();

        if ($attributeCount > 5) {
            return true;
        } else {
            return false;
        }
    }

    public function company_has_category()
    {
        $categories = $this->categories()->count();

        if ($categories > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function company_is_verified()
    {

        /* TODO: Add dynamic verification column to shops table */
        $verification_status = true;

        if ($verification_status === 'yes') {
            return true;
        } else {
            return false;
        }
    }

    public function profile_completeness()
    {
        $total = 0;
        if ($this->company_has_description()) {
            $total += 25;
        }

        if ($this->company_has_logo()) {
            $total += 25;
        }

        if ($this->company_has_required_attributes()) {
            $total += 25;
        }

        if ($this->company_has_category()) {
            $total += 25;
        }
        return $total;
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
}

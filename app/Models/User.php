<?php

namespace App\Models;

use App\Models\Auth\User as Authenticatable;
use App\Notifications\EmailVerificationNotification;
use App\Traits\CoreMetaTrait;
use App\Traits\GalleryTrait;
use App\Traits\SocialReactionsTrait;
use App\Traits\PermalinkTrait;
use App\Traits\SocialAccounts;
use App\Traits\UploadTrait;
use App\Traits\SocialFollowingTrait;
use App\Traits\OwnershipTrait;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Traits\HasWalletFloat;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Cashier\Billable;
use Laravel\Nova\Auth\Impersonatable;
use DB;
use Carbon\Carbon;


class User extends Authenticatable implements MustVerifyEmail, Wallet, WalletFloat
{
    use Notifiable, HasApiTokens;
    use SoftDeletes;
    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
    use OwnershipTrait;
    use SocialAccounts;
    use HasWalletFloat;
    use PermalinkTrait;
    use CoreMetaTrait;
    use SocialReactionsTrait;
    use SocialFollowingTrait;
    use Impersonatable;
    use Billable;

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'created_at' => 'date',
        'banned' => 'boolean',
        'verified' => 'boolean',
        'is_temp' => 'boolean',
    ];

    public static array $user_types = ['admin', 'moderator', 'seller', 'staff', 'customer'];

    public static array $tenant_user_types = ['admin', 'moderator'];

    public static array $vendor_user_types = ['seller', 'staff'];

    public static array $non_customer_user_types = ['admin', 'moderator', 'seller', 'staff'];

    public static string $customer_type = 'customer';

    public function sendEmailVerificationNotification()
    {
        $this->notify(new EmailVerificationNotification());
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return string
     */
    public function routeNotificationForSlack($notification)
    {
        return 'https://hooks.slack.com/services/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';
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'surname', 'user_type', 'email', 'is_temp', 'entity', 'password', 'phone', 'provider_id', 'email_verified_at', 'verification_code', 'session_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isEmailVerified()
    {
        return !empty($this->email_verified_at);
    }

    public function hasShop()
    {
        return ($this->isAdmin() || $this->isSeller() || $this->isStaff()) && ($this->shop?->count() > 0);
    }

    public function isAdmin()
    {
        return $this->user_type === 'admin';
    }

    public function isSeller()
    {
        return $this->user_type === 'seller';
    }

    public function isStaff()
    {
        return $this->user_type === 'staff';
    }

    public function isCustomer()
    {
        return $this->user_type === 'customer';
    }

    /*
     * Scope searchable parameters
     */
    public function scopeSearch($query, $term)
    {
        return $query->where(
            fn ($query) =>  $query
                ->where('name', 'like', '%' . $term . '%')
                ->orWhere('surname', 'like', '%' . $term . '%')
                ->orWhere('email', 'like', '%' . $term . '%')
        );
    }

    public function user_meta()
    {
        return $this->hasMany(UserMeta::class, 'user_id');
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function social_accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function seller()
    {
        return $this->hasOne(Seller::class);
    }

    public function affiliate_user()
    {
        return $this->hasOne(AffiliateUser::class);
    }

    public function affiliate_withdraw_request()
    {
        return $this->hasMany(AffiliateWithdrawRequest::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function shop()
    {
        return $this->morphedByMany(Shop::class, 'subject', 'user_relationships');
    }

    public function blog_posts()
    {
        return $this->morphToMany(BlogPost::class, 'subject', 'blog_post_relationships');
    }

    public function portfolio()
    {
        return $this->morphToMany(BlogPost::class, 'subject', 'blog_post_relationships')->where('type', 'portfolio');
    }

    public function social_posts()
    {
        return $this->hasMany(SocialPost::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function purchasedProducts()
    {
        // return DB::table('products')->;
    }

    public function wallets()
    {
        return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function affiliate_log()
    {
        return $this->hasMany(AffiliateLog::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function plans()
    {
        return $this->morphedByMany(Plan::class, 'subject', 'user_subscriptions')
            ->withPivot('start_date', 'end_date', 'qty', 'data');
    }

    public function plan_subscriptions()
    {
        return $this->hasMany(UserSubscription::class)->where('subject_type', Plan::class);
    }

    // TODO: Shoud be appended to User model based on if Quiz Feature is added to the tenant or not!
    public function quizzes()
    {
        return $this->hasMany(WeQuiz::class);
    }

    /**
     * Check if user is subscribed to a specific plan
     *
     * @param int|string $plan_slug - can be both slug or ID
     */
    public function subscribedTo($plan_slug)
    {
        if (is_numeric($plan_slug)) {
            return $this->plans->where('id', $plan_slug)->count() > 0;
        }

        return $this->plans->where('slug', $plan_slug)->count() > 0;
    }

    public function isSubscribed()
    {
        return $this->plan_subscriptions->count() > 0;
    }

    public function isOnTrial()
    {
        /* TODO: Adjust this for multiplan */
        if ($this->isSubscribed()) {
            return $this->plan_subscriptions->first()?->status == 'trial';
        } else {
            return false;
        }
    }

    public function getDynamicModelUploadProperties(): array
    {
        return [];
    }

    public static function getAvailableUserTypes($only_vendor_types = true)
    {
        // Vendor types ar: Seller and Staff. Admin and moderator are tenant user types!
        return collect($only_vendor_types ? self::$vendor_user_types : self::$user_types)
            ->keyBy(fn ($item, $key) => $item)
            ->map(fn ($item) => ucfirst($item))
            ->toArray();
    }

    public function userTypeAttribute()
    {
        return $this->type;
    }

    // OLD
    public function recently_viewed_products()
    {

        $data = Activity::where('subject_type', \App\Models\Product::class)
            ->where('description', 'viewed')
            ->where('causer_id', $this->id)->orderBy('created_at', 'desc')
            ->groupBy('subject_id')
            ->take(5)
            ->get();

        return $data;
    }

    public function recently_viewed_shops()
    {
        $data = Activity::where('subject_type', \App\Models\Shop::class)
            ->where('causer_id', $this->id)->orderBy('created_at', 'desc')
            ->groupBy('subject_id')
            ->paginate(18);

        return $data;
    }

    public function getVerifiedAttribute()
    {
        if ($this->verification_code) {
            return true;
        } else {
            return false;
        }
    }

    /* TODO: Move this to verification trait */
    public function isVerified()
    {
        /* TODO: Add dynamic verification column to shops table */
        if ($this->verification_code) {
            return true;
        } else {
            return false;
        }
    }

    public function getUserMeta($key)
    {
        $user_meta = $this->user_meta->where('key', $key)->keyBy('key')->toArray();

        castValuesForGet($user_meta, UserMeta::metaDataTypes());

        return $user_meta[$key] ?? null;
    }

    /**
     * Get the route name for the model.
     *
     * @return string
     */
    public static function getRouteName()
    {
        return 'user.profile.single';
    }

    /* TODO: Make this into reporting Trait */
    public function scopeByDays($query, $days)
    {
        //one day (today)
        $date = Carbon::now();

        //one month / 30 days
        $date = Carbon::now()->subDays($days);

        return $query->where('created_at', '>' , $date);
    }
}

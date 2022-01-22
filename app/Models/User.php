<?php

namespace App\Models;

use App\Traits\GalleryTrait;
use App\Traits\UploadTrait;
use App\Traits\SocialAccounts;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;
use App\Notifications\EmailVerificationNotification;
use Spark\Billable;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;

use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Authenticatable implements MustVerifyEmail, Wallet, WalletFloat
{
    use Notifiable, HasApiTokens;
    use HasRoles;
    use HasApiTokens;
    use Notifiable;
    use Billable;
    use LogsActivity;
    use UploadTrait;
    use GalleryTrait;
    use SocialAccounts;
    use HasWalletFloat;

    protected $casts = [
        'trial_ends_at' => 'datetime',
        'banned' => 'boolean'
    ];

    public static array $user_types = ['admin','moderator','seller','staff','customer'];
    public static array $tenant_user_types = ['admin','moderator'];
    public static array $vendor_user_types = ['seller','staff'];
    public static array $non_customer_user_types = ['admin','moderator','seller','staff'];
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
        'name', 'email', 'password', 'address', 'city', 'postal_code', 'phone', 'country', 'provider_id', 'email_verified_at', 'verification_code'
    ];

    /**
    * The attributes that should be hidden for arrays.
    *
    * @var array
    */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function isAdmin() {
        return $this->user_type === 'admin';
    }

    public function isSeller() {
        return $this->user_type === 'seller';
    }

    public function isStaff() {
        return $this->user_type === 'staff';
    }

    public function isCustomer() {
        return $this->user_type === 'customer';
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function social_accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }

    public function customer()
    {
    return $this->hasOne(Customer::class);
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

    public function staff()
    {
    return $this->hasOne(Staff::class);
    }

    public function orders()
    {
    return $this->hasMany(Order::class);
    }

    public function wallets()
    {
    return $this->hasMany(Wallet::class)->orderBy('created_at', 'desc');
    }

    public function club_point()
    {
    return $this->hasOne(ClubPoint::class);
    }

    public function customer_package()
    {
        return $this->belongsTo(CustomerPackage::class);
    }

    public function customer_package_payments()
    {
        return $this->hasMany(CustomerPackagePayment::class);
    }

    public function customer_products()
    {
        return $this->hasMany(CustomerProduct::class);
    }

    public function seller_package_payments()
    {
        return $this->hasMany(SellerPackagePayment::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
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


    public function getDynamicModelUploadProperties(): array
    {
        return [

        ];
    }

    public function getAvatar(array $options = []) {
        return $this->getUpload('thumbnail', $options);
    }

    public static function getAvailableUserTypes($only_vendor_types = true) {
        // Vendor types ar: Seller and Staff. Admin and moderator are tenant user types!
        return collect($only_vendor_types ? self::$vendor_user_types : self::$user_types)
            ->keyBy(fn($item, $key) => $item)
            ->map(fn($item) => ucfirst($item))
            ->toArray();
    }

    public function recently_viewed_products() {
        $data = Activity::where('subject_type', 'App\Models\Product')
        ->where('causer_id', $this->id)->orderBy('created_at', 'desc')
        ->groupBy('subject_id')
        ->get();

        return $data;
    }

    public function recently_viewed_shops() {
        $data = Activity::where('subject_type', 'App\Models\Shop')
        ->where('causer_id', $this->id)->orderBy('created_at', 'desc')
        ->groupBy('subject_id')
        ->get();

        return $data;
    }
}

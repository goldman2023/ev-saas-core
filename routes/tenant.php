<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffiliateBannerController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\EVAccountController;
use App\Http\Controllers\EVCartController;
use App\Http\Controllers\EVCategoryController;
use App\Http\Controllers\EVCheckoutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EVOrderController;
use App\Http\Controllers\EVProductController;
use App\Http\Controllers\EVSaaSController;
use App\Http\Controllers\EVWishlistController;
use App\Http\Controllers\EVShopController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OnboardingController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\Tenant\ApplicationSettingsController;
use App\Http\Controllers\Tenant\DownloadInvoiceController;
use App\Http\Controllers\Tenant\UserSettingsController;
use App\Http\Middleware\OwnerOnly;
use App\Http\Middleware\VendorMode;
use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Models\Product;
use App\Models\Shop;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Features\UserImpersonation;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/*
|--------------------------------------------------------------------------
| Tenant Routes
|--------------------------------------------------------------------------
|
| Here you can register the tenant routes for your application.
| These routes are loaded by the TenantRouteServiceProvider.
|
| Feel free to customize them however you want. Good luck!
|
*/

Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomainAndVendorDomains::class,
    PreventAccessFromCentralDomains::class,
    VendorMode::class,
])->namespace('App\Http\Controllers')->group(function () {
    Route::get('/we-edit-grape', 'WeEditController@grapejs_index')->name('we-edit-grape.index');

    Route::group([
        'middleware' => ['auth'],
    ], function () {
        Route::get('/we-analytics', 'WeAnalyticsController@index')->name('analytics.index');
        Route::get('/we-menu', 'WeMenuController@index')->name('menu.index');

        Route::get('/we-edit', 'WeEditController@index')->name('we-edit.index');
        Route::get('/we-edit/flow', 'WeEditController@flow')->name('we-edit.flow.pages');
        Route::get('/we-edit/flow/menu', 'WeEditController@menuFlow')->name('we-edit.flow.menu');
    });




    // Route to show after creating new tenant:
    Route::get('/welcome', [OnboardingController::class, 'welcome'])->name('onboarding.step1')->middleware(['auth']);
    Route::get('/welcome/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2')->middleware(['auth']);
    Route::post('/welcome/profile/store', [OnboardingController::class, 'profile_store'])->name('onboarding.profile.store')->middleware(['auth']);
    Route::get('/welcome/step3', [OnboardingController::class, 'step3'])->name('onboarding.step3')->middleware(['auth']);
    Route::get('/welcome/step4', [OnboardingController::class, 'step4'])->name('onboarding.step4')->middleware(['auth']);


    // Homepage For Multi/Single Vendor mode
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Feed Page (Possible new homepage)
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.home');

    Route::post('/category/nav-element-list', [HomeController::class, 'get_category_items'])->name('category.elements');

    Route::get('/sitemap.xml', function () {
        return base_path('sitemap.xml');
    });

    Route::get('/refresh-csrf', function () {
        return csrf_token();
    });


    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
    // Tracking
    Route::get('/aff{id}', [AffiliateBannerController::class, 'track'])->name('affiliate_banner.track');
    Route::get('/link{id}', [CompanyController::class, 'track_website_clicks'])->name('website_clicks.track');
    // Tracking - END


    Route::resource('shops', 'ShopController');
    Route::resource('ev-social-commerce', 'SocialCommerceController');

    Route::get('/business/register', 'ShopController@create')->name('business.register');

    Auth::routes(['verify' => true]);
    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::get('/email/resend', [VerificationController::class, 'resend'])->name('email.verification.resend');
    Route::get('/verification-confirmation/{code}', [VerificationController::class, 'verification_confirmation'])->name('email.verification.confirmation');
    Route::get('/email_change/callback', [HomeController::class, 'email_change_callback'])->name('email_change.callback');
    Route::post('/password/reset/email/submit', [HomeController::class, 'reset_password_with_code'])->name('user.password.update');


    Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');
    Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');


    Route::get('/social-login/redirect/{provider}', [SocialController::class, 'redirectLoginToProvider'])->name('social.login');
    Route::get('/social-login/{provider}/callback', [SocialController::class, 'handleProviderLoginCallback'])->name('social.login.callback');
    Route::get('/social-connect/redirect/{provider}', [SocialController::class, 'redirectConnectToProvider'])->name('social.connect');
    Route::get('/social-connect/{provider}/callback', [SocialController::class, 'handleProviderConnectCallback'])->name('social.connect.callback');

    Route::get('/business/login', [HomeController::class, 'login'])->name('business.login');
    Route::post('/business/login', [HomeController::class, 'business_login'])->name('business.login.submit');
    Route::get('/users/login', [HomeController::class, 'login_users'])->name('user.login');
    Route::get('/users/register', [HomeController::class, 'registration'])->name('user.registration');
    Route::post('/users/login/cart', [HomeController::class, 'cart_login'])->name('cart.login.submit');
    Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/admin/login')->name('login.attempt')->uses('Auth\LoginController@login');

    Route::get('/search', [HomeController::class, 'search'])->name('products.index');
    Route::get('/search?q={search}', [HomeController::class, 'search'])->name('suggestion.search');
    Route::post('/ajax-search', [HomeController::class, 'ajax_search'])->name('search.ajax');

    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::get('/product/{slug}', [EVProductController::class, 'show'])->name(Product::getRouteName());

    // Category archive pages
    Route::get('/category/{slug}', [EVCategoryController::class, 'archiveByCategory'])->where('slug', '.+')->name('category.index');
    Route::get('/products/category/{slug}', [EVProductController::class, 'productsByCategory'])->where('slug', '.+')->name('category.products.index');
    Route::get('/products/brand/{brand_slug}', [HomeController::class, 'listingByBrand'])->name('products.brand');


    // Blog Posts
    Route::get('/shop/{shop_slug}/blog/posts/{slug}', [EVCategoryController::class, 'archiveByCategory'])->name('shop.blog.post.index');

    // Shop pages
    Route::get('/shop/{slug}', [EVShopController::class, 'single'])->name(Shop::getRouteName());
    Route::get('/shops', [MerchantController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}/info/{sub_page}', [CompanyController::class, 'show'])->name('shop.sub-page');
    Route::get('/shop/{slug}/{type}', [HomeController::class, 'filter_shop'])->name('shop.visit.type');

    // Cart page
    Route::get('/cart', [EVCartController::class, 'index'])->name('cart');
    Route::get('/wishlist', [EVWishlistController::class, 'index'])->name('wishlist');
    Route::get('/wishlist/views', [EVWishlistController::class, 'views'])->name('wishlist.views');

    // Checkout Routes
    Route::group(['middleware' => ['checkout']], function () {
        Route::get('/checkout', [EVCheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [EVCheckoutController::class, 'store'])->name('checkout.post');
        Route::get('/checkout-single', [EVCheckoutController::class, 'single'])->name('checkout.single.page');

        Route::get('/order-received/{id}', [EVCheckoutController::class, 'orderReceived'])->name('checkout.order.received');
    });

    /* Old active commerce stripe routes */
    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('/stripe/create-checkout-session', [StripePaymentController::class, 'stripe'])->name('stripe.get_token');
    Route::any('/stripe/payment/callback', [StripePaymentController::class, 'callback'])->name('stripe.callback');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
    //Stripe END

    Route::resource('subscribers', 'SubscriberController');
    /* TODO: Move some logic to brand, category, seller controllers as home controller holds too much logic*/
    Route::get('/brands', [HomeController::class, 'all_brands'])->name('brands.all');
    Route::get('/categories', [HomeController::class, 'all_categories'])->name('categories.all');
    Route::get('/sellers', [CompanyController::class, 'index'])->name('sellers');

    Route::group(['middleware' => []], function () {
        Route::resource('support_ticket', 'SupportTicketController');
        Route::post('support_ticket/reply', 'SupportTicketController@seller_store')->name('support_ticket.seller_store');
    });

    //Blog Section
    Route::get('/news', [BlogController::class, 'all_blog'])->name('news');
    Route::get('/news/{slug}', [BlogController::class, 'blog_details'])->name('news.details');
    Route::get('/news/category/{slug}', [BlogController::class, 'blog_category'])->name('news.category');

    // Chat

    Route::get('/chat', 'ChatController@index')->name('chat.index');


    /* Customer Management - BY EIM */
    Route::resource('customers', 'CustomerController');

    // Tenant Management routes - added from SaaS Boilerplate
    Route::get('/impersonate/{token}', function ($token) {
        return UserImpersonation::makeResponse($token);
    })->name('tenant.impersonate');

    Route::get('/settings/user', [UserSettingsController::class, 'show'])->name('tenant.settings.user');
    Route::post('/settings/user/personal', 'UserSettingsController@personal')->name('tenant.settings.user.personal');
    Route::post('/settings/user/password', 'UserSettingsController@password')->name('tenant.settings.user.password');

    Route::middleware(OwnerOnly::class)->group(function () {
        Route::get('/settings/application', [ApplicationSettingsController::class, 'show'])->name('tenant.settings.application');
        Route::post('/settings/application/configuration', [ApplicationSettingsController::class, 'storeConfiguration'])->name('tenant.settings.application.configuration');
        Route::get('/settings/application/invoice/{id}/download', [DownloadInvoiceController::class])->name('tenant.invoice.download');
    });


    //Custom page
    Route::get('/page/{slug}', 'PageController@show_custom_page')->name('custom-pages.show_custom_page');
    Route::get('/shop/create', 'PageController@show_custom_page')->name('shop.create');
});

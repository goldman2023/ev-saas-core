<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\AffiliateBannerController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
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
use App\Http\Controllers\EVCheckoutController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EVOrderController;
use App\Http\Controllers\EVProductController;
use App\Http\Controllers\EVSaaSController;
use App\Http\Controllers\EVWishlistController;
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

    /* This is experimental, adding it here for now */
    Route::resource('/ev-docs/components', 'Ev\ComponentController')->middleware('auth');


    // Route to show after creating new tenant:
    Route::get('/welcome', [OnboardingController::class, 'welcome'])->name('tenant.welcome');


    // Homepage For Multi/Single Vendor mode
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Feed Page (Possible new homepage)
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.home');
    //Home Page

    //Category dropdown menu ajax call
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
    Route::resource('courses', 'CoursesController');
    Route::resource('ev-social-commerce', 'SocialCommerceController');
    Route::resource('ev-tutorials', 'TutorialController');

    Route::get('/business/register', 'ShopController@create')->name('business.register');


    Auth::routes(['verify' => true]);
    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::get('/email/resend', [VerificationController::class, 'resend'])->name('email.verification.resend');
    Route::get('/verification-confirmation/{code}', [VerificationController::class, 'verification_confirmation'])->name('email.verification.confirmation');
    Route::get('/email_change/callback', [HomeController::class, 'email_change_callback'])->name('email_change.callback');
    Route::post('/password/reset/email/submit', [HomeController::class, 'reset_password_with_code'])->name('user.password.update');


    Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');
    Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');

    Route::get('/social-login/redirect/{provider}', [LoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('/social-login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
    Route::get('/business/login', [HomeController::class, 'login'])->name('business.login');
    Route::post('/business/login', [HomeController::class, 'business_login'])->name('business.login.submit');
    Route::get('/users/login', [HomeController::class, 'login_users'])->name('user.login');
    Route::get('/users/register', [HomeController::class, 'registration'])->name('user.registration');
    Route::post('/users/login/cart', [HomeController::class, 'cart_login'])->name('cart.login.submit');
    Route::get('/admin/login', 'Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/admin/login')->name('login.attempt')->uses('Auth\LoginController@login');

    Route::get('/customer-products', [CustomerProductController::class, 'customer_products_listing'])->name('customer.products');
    Route::get('/customer-products?category={category_slug}', [CustomerProductController::class, 'search'])->name('customer_products.category');
    Route::get('/customer-products?city={city_id}', [CustomerProductController::class, 'search'])->name('customer_products.city');
    Route::get('/customer-products?q={search}', [CustomerProductController::class, 'search'])->name('customer_products.search');
    Route::get('/customer-products/admin', [HomeController::class, 'profile_edit'])->name('customer.profile.edit');
    Route::get('/customer-product/{slug}', [CustomerProductController::class, 'customer_product'])->name('customer.product');
    Route::get('/customer-packages', [HomeController::class, 'premium_package_index'])->name('customer_packages_list_show');

    /* TODO: Investigate this is causing some issues */
    Route::get('/search', [HomeController::class, 'search'])->name('products.index');
    Route::get('/search?q={search}', [HomeController::class, 'search'])->name('suggestion.search');
    Route::post('/ajax-search', [HomeController::class, 'ajax_search'])->name('search.ajax');

    Route::get('/search', [HomeController::class, 'search'])->name('search');

    Route::get('/product/{slug}', [HomeController::class, 'product'])->name(Product::ROUTING_SINGULAR_NAME_PREFIX.'.single');
    Route::get('/category/{category_slug}', [HomeController::class, 'listingByCategory'])->name(Product::ROUTING_PLURAL_NAME_PREFIX.'.category');
    Route::get('/brand/{brand_slug}', [HomeController::class, 'listingByBrand'])->name(Product::ROUTING_PLURAL_NAME_PREFIX.'.brand');
    Route::post('/product/variant_price', [HomeController::class, 'variant_price'])->name(Product::ROUTING_PLURAL_NAME_PREFIX.'.variant_price');

    // Cart page
    Route::get('/cart', [EVCartController::class, 'index'])->name('cart');
    Route::get('/wishlist', [EVWishlistController::class, 'index'])->name('wishlist');
    Route::get('/wishlist/views', [EVWishlistController::class, 'views'])->name('wishlist.views');

    //Checkout Routes
    Route::group(['middleware' => ['checkout']], function () {
        Route::get('/checkout', [EVCheckoutController::class, 'index'])->name('checkout');
        Route::post('/checkout', [EVCheckoutController::class, 'store'])->name('checkout.post');

        Route::get('/order-received/{id}', [EVCheckoutController::class, 'orderReceived'])->name('checkout.order.received');

//        Route::any('/checkout/delivery_info', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
//        Route::post('/checkout/payment_select', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');
//
//        Route::get('/order-confirmed', 'CheckoutController@order_confirmed')->name('order_confirmed');
//        Route::post('/payment', 'CheckoutController@checkout')->name('payment.checkout');
//        Route::post('/get_pick_up_points', 'HomeController@get_pick_up_points')->name('shipping_info.get_pick_up_points');
//        Route::get('/payment-select', 'CheckoutController@get_payment_info')->name('checkout.payment_info');
//        Route::post('/apply_coupon_code', 'CheckoutController@apply_coupon_code')->name('checkout.apply_coupon_code');
//        Route::post('/remove_coupon_code', 'CheckoutController@remove_coupon_code')->name('checkout.remove_coupon_code');
//        //Club point
//        Route::post('/apply-club-point', 'CheckoutController@apply_club_point')->name('checkout.apply_club_point');
//        Route::post('/remove-club-point', 'CheckoutController@remove_club_point')->name('checkout.remove_club_point');
    });

    // Shop pages
    Route::get('/shop/{slug}', [MerchantController::class, 'shop'])->name('shop.visit');
    Route::get('/shops', [MerchantController::class, 'index'])->name('shop.index');
    Route::get('/shop/{slug}/info/{sub_page}', [CompanyController::class, 'show'])->name('shop.sub-page');
    Route::get('/shop/{slug}/{type}', [HomeController::class, 'filter_shop'])->name('shop.visit.type');
    Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.visit');


    Route::post('/cart/nav-cart-items', [CartController::class, 'updateNavCart'])->name('cart.nav_cart');
    Route::post('/cart/show-cart-modal', [CartController::class, 'showCartModal'])->name('cart.showCartModal');
    Route::post('/cart/addtocart', [CartController::class, 'addToCart'])->name('cart.addToCart');
    Route::post('/cart/removeFromCart', [CartController::class, 'removeFromCart'])->name('cart.removeFromCart');
    Route::post('/cart/updateQuantity', [CartController::class, 'updateQuantity'])->name('cart.updateQuantity');

    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('/stripe/create-checkout-session', [StripePaymentController::class, 'stripe'])->name('stripe.get_token');
    Route::any('/stripe/payment/callback', [StripePaymentController::class, 'callback'])->name('stripe.callback');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
    //Stripe END


    Route::get('/compare', [CompareController::class, 'index'])->name('compare');
    Route::get('/compare/reset', [CompareController::class, 'reset'])->name('compare.reset');
    Route::post('/compare/addToCompare', [CompareController::class, 'addToCompare'])->name('compare.addToCompare');

    Route::resource('subscribers', 'SubscriberController');
    /* TODO: Move some logic to brand, category, seller controllers as home controller holds too much logic*/
    Route::get('/brands', [HomeController::class, 'all_brands'])->name('brands.all');
    Route::get('/categories', [HomeController::class, 'all_categories'])->name('categories.all');
    Route::get('/sellers', [CompanyController::class, 'index'])->name('sellers');

    Route::group(['middleware' => []], function () {
        Route::get('/dashboard/thank-you', 'CompanyController@thankYouPage')->name('company.thank-you');
        Route::get('/profile', 'HomeController@profile')->name('profile');
        Route::get('/attributes', 'HomeController@attributes')->name('attributes');
        Route::post('/new-user-verification', 'HomeController@new_verify')->name('user.new.verify');
        Route::post('/new-user-email', 'HomeController@update_email')->name('user.change.email');
        Route::post('/customer/update-profile', 'HomeController@customer_update_profile')->name('customer.profile.update');
        Route::post('/seller/update-profile', 'HomeController@seller_update_profile')->name('seller.profile.update');
        Route::post('/seller/update-category', 'HomeController@seller_update_category')->name('seller.category.update');
        Route::post('/update_attributes', 'HomeController@update_attributes')->name('frontend.attributes.update');

        Route::resource('purchase_history', 'PurchaseHistoryController')->parameters([
            'purchase_history' => 'id',
        ]);
        Route::post('/purchase_history/details', 'PurchaseHistoryController@purchase_history_details')->name('purchase_history.details');
        //    Route::get('/purchase_history/destroy/{id}', 'PurchaseHistoryController@destroy')->name('purchase_history.destroy');

        Route::resource('wishlists', 'WishlistController');
        Route::post('/wishlists/remove', 'WishlistController@destroy')->name('wishlists.remove');

        Route::get('/wallet', 'WalletController@index')->name('wallet.index');
        Route::post('/recharge', 'WalletController@recharge')->name('wallet.recharge');

        Route::resource('support_ticket', 'SupportTicketController');
        Route::post('support_ticket/reply', 'SupportTicketController@seller_store')->name('support_ticket.seller_store');

        Route::resource('customer_products', 'CustomerProductController')->parameters([
            'customer_products' => 'id',
        ]);
        Route::post('/customer_packages/purchase', 'CustomerPackageController@purchase_package')->name('customer_packages.purchase');
        Route::post('/customer_products/published', 'CustomerProductController@updatePublished')->name('customer_products.published');
        Route::post('/customer_products/status', 'CustomerProductController@updateStatus')->name('customer_products.update.status');

        Route::get('digital_purchase_history', 'PurchaseHistoryController@digital_index')->name('digital_purchase_history.index');
    });

    Route::group(['prefix' => 'seller', 'middleware' => ['seller', 'verified', 'user']], function () {
        Route::get('/products', 'HomeController@seller_product_list')->name('seller.products');
        Route::get('/product/upload', 'HomeController@show_product_upload_form')->name('seller.products.upload');
        Route::get('/product/{id}/edit', 'HomeController@show_product_edit_form')->name('seller.products.edit');
        Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');

        Route::resource('payments', 'PaymentController');

        Route::get('/shop/apply_for_verification', 'ShopController@verify_form')->name('shop.verify');
        Route::post('/shop/apply_for_verification', 'ShopController@verify_form_store')->name('shop.verify.store');

        Route::get('/reviews', 'ReviewController@seller_reviews')->name('reviews.seller');

        //digital Product
        Route::get('/digitalproducts', 'HomeController@seller_digital_product_list')->name('seller.digitalproducts');
        Route::get('/digitalproducts/upload', 'HomeController@show_digital_product_upload_form')->name('seller.digitalproducts.upload');
        Route::get('/digitalproducts/{id}/edit', 'HomeController@show_digital_product_edit_form')->name('seller.digitalproducts.edit');

        //Events
        Route::get('/events', 'EventController@seller_events')->name('seller.events');
        Route::get('/events/upload', 'EventController@seller_event_create')->name('seller.event.create');
        Route::get('/events/{id}/edit', 'EventController@seller_event_edit')->name('seller.event.edit');

        // jobs
        Route::get('/jobs', 'JobController@seller_jobs')->name('seller.jobs');
        Route::get('/jobs/upload', 'JobController@seller_jobs_create')->name('seller.jobs.upload');
        Route::get('/jobs/{id}/edit', 'JobController@seller_jobs_edit')->name('seller.jobs.edit');
    });



    Route::get('/track_your_order', 'HomeController@trackOrder')->name('orders.track');


    Route::get('/all_jobs', 'JobController@all_jobs')->name('jobs.all');
    Route::get('/shops/{shop_slug}/jobs/{job_slug}', 'JobController@job')->name('jobs.visit');

    Route::get('/sellerpolicy', 'HomeController@sellerpolicy')->name('sellerpolicy');
    Route::get('/returnpolicy', 'HomeController@returnpolicy')->name('returnpolicy');
    Route::get('/supportpolicy', 'HomeController@supportpolicy')->name('supportpolicy');
    Route::get('/terms', 'HomeController@terms')->name('terms');
    Route::get('/privacypolicy', 'HomeController@privacypolicy')->name('privacypolicy');

    Route::resource('companies', 'CompanyController');
    Route::get('/companies/category/{category_slug}', 'CompanyController@listingByCategory')->name('companies.category');


    //Blog Section
    Route::get('/news', [BlogController::class, 'all_blog'])->name('news');
    Route::get('/news/{slug}', [BlogController::class, 'blog_details'])->name('news.details');
    Route::get('/news/category/{slug}', [BlogController::class, 'blog_category'])->name('news.category');

    // Chat
    Route::get('/styleguide', 'PageController@styleguide')->name('styleguide.index');

    Route::get('/chat', 'ChatController@index')->name('chat.index');
    Route::get('/pricing', 'PageController@pricing')->name('landing.pricing');


    // Mailchimp subscriptions routes
    Route::post('/subscribe/{type}', 'Integrations\MailchimpController@subscribe')
        ->name('mailchimp.subscribe');

    Route::get('/page/{slug}', 'PageController@show_static_page')->name('page.static_page');

    // Get Stream Integration routes
    Route::get('/feed/all', 'Integrations\GetStreamControler@index');


//    Route::resource('addresses', 'AddressController');
//    Route::post('/addresses/update/{id}', 'AddressController@update')->name('addresses.update');
//    Route::get('/addresses/destroy/{id}', 'AddressController@destroy')->name('addresses.destroy');
//    Route::get('/addresses/set_default/{id}', 'AddressController@set_default')->name('addresses.set_default');

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
    Route::get('/{slug}', 'PageController@show_custom_page')->name('custom-pages.show_custom_page');
});

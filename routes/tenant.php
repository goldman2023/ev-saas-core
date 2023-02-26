<?php

use App\Models\Plan;
use App\Models\Shop;
use App\Models\Product;
use App\Models\CourseItem;
use App\Http\Controllers\App;
use App\Http\Middleware\OwnerOnly;
use App\Http\Middleware\VendorMode;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GrapeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\EVCartController;
use App\Http\Controllers\EVPlanController;
use App\Http\Controllers\EVSaaSController;
use App\Http\Controllers\EVShopController;
use App\Http\Controllers\QuotesController;
use App\Http\Controllers\WeEditController;
use App\Http\Controllers\WeQuizController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\BlogPostController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\EVAccountController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\EVCategoryController;
use App\Http\Controllers\EVWishlistController;
// use App\Http\Controllers\WeMenuController;
use App\Http\Controllers\OnboardingController;
use Stancl\Tenancy\Features\UserImpersonation;
use App\Http\Controllers\Auth\SocialController;
use App\Http\Controllers\WeAnalyticsController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StripePaymentController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\WeSubscriptionsController;
use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Tenant\UserSettingsController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use App\Http\Controllers\EVAccountVerificationController;
use App\Http\Controllers\Tenant\DownloadInvoiceController;
use App\Http\Controllers\Integrations\PixProLicenseController;
use App\Http\Controllers\Tenant\ApplicationSettingsController;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;

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
    InitializeTenancyByDomainAndVendorDomains::class,
    VendorMode::class,
])->group(function () {

    Route::get('/sitemap', [SitemapController::class, 'display'])->name('sitemap.show');


    Route::middleware('auth')->group(function () {
        Route::get('/dashboard/we-analytics', [WeAnalyticsController::class, 'index'])->name('analytics.index');
        // Route::get('/we-menu', [WeMenuController::class, 'index'])->name('menu.index');
        Route::get('/sitemap/generate', [SitemapController::class, 'generate'])->name('sitemap.generate');

        Route::get('/we-edit', [WeEditController::class, 'index'])->name('we-edit.index');
        Route::get('/we-edit/flow', [WeEditController::class, 'flow'])->name('we-edit.flow.pages');
        Route::get('/we-edit/flow/menu', [WeEditController::class, 'menuFlow'])->name('we-edit.flow.menu');

        Route::get('/we-grape/{pageID?}', [GrapeController::class, 'index'])->name('grape.index');
        Route::post('/we-grape/{pageID}/save/{type}', [GrapeController::class, 'save_custom_html'])->name('grape.save');
        Route::get('/we-grape/section-editor/{sectionID}', [GrapeController::class, 'edit_section'])->name('grape.section-editor');
    });

    // Webhooks
    Route::post('/webhooks/stripe', [StripePaymentController::class, 'webhooks'])->name('webhooks.stripe');
    Route::get('/stripe/create-checkout-session', [StripePaymentController::class, 'generateCheckoutSessionLink'])->name('stripe.checkout_redirect');
    // Route::post('/stripe/create-checkout-session', [StripePaymentController::class, 'generateCheckoutSessionLink'])->name('stripe.checkout_redirect');


    // Route to show after creating new tenant:
    Auth::routes(['verify' => true]);

    // User/Business/Admin login/register routes
    Route::get('/admin/login', [LoginController::class, 'admin_login'])->name('admin.login');
    Route::get('/business/login', [LoginController::class, 'business_login'])->name('business.login');
    Route::get('/business/register', [RegisterController::class, 'business_registration'])->name('business.registration');
    Route::get('/users/login', [LoginController::class, 'user_login'])->name('user.login');
    Route::get('/users/register', [RegisterController::class, 'user_registration'])->name('user.registration');
    Route::get('/users/register/{token}', [RegisterController::class, 'user_registration'])->name('user.invite.registration'); // invite user route
    Route::get('/users/register/finalize/{id}/{hash}', [RegisterController::class, 'user_finalize_registration'])->name('user.registration.finalize');


    Route::get('/logout', [LoginController::class, 'logout'])->name('user.logout');
    Route::post('/password/reset/email/submit', [HomeController::class, 'reset_password_with_code'])->name('user.password.update');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'forgot_password'])->name('user.forgot-password');
    Route::get('/reset-password', [ForgotPasswordController::class, 'reset_password'])->name('user.reset-password');

    Route::get('/welcome', [OnboardingController::class, 'step2'])->name('onboarding.step1')->middleware(['auth']);
    Route::get('/welcome/step2', [OnboardingController::class, 'step2'])->name('onboarding.step2')->middleware(['auth']);
    Route::post('/welcome/profile/store', [OnboardingController::class, 'profile_store'])->name('onboarding.profile.store')->middleware(['auth']);
    Route::get('/welcome/work-and-education', [OnboardingController::class, 'work_and_education'])->name('onboarding.work-and-education')->middleware(['auth']);
    Route::get('/welcome/step3', [OnboardingController::class, 'step3'])->name('onboarding.step3')->middleware(['auth']);
    Route::get('/welcome/step4', [OnboardingController::class, 'step4'])->name('onboarding.step4')->middleware(['auth']);
    Route::get('/welcome/verification', [OnboardingController::class, 'verification'])->name('onboarding.verification')->middleware(['auth']);
    Route::get('/email/verify', [EVAccountVerificationController::class, 'verification_page'])->name('user.email.verification.page');
    Route::get('/email/verify/{id}/{hash}', [EVAccountVerificationController::class, 'verify'])->name('user.email.verification.verify');
    Route::get('/email/verify/resend', [EVAccountVerificationController::class, 'resend'])->name('user.email.verification.resend');

    // Homepage For Multi/Single Vendor mode
    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::post('/category/nav-element-list', [HomeController::class, 'get_category_items'])->name('category.elements');

    Route::get('/sitemap.xml', function () {
        return base_path('sitemap.xml');
    });

    Route::get('/refresh-csrf', function () {
        return csrf_token();
    });

    // Route::resource('shops', 'ShopController');
    Route::resource('ev-social-commerce', \App\Http\Controllers\SocialCommerceController::class);

    Route::get('/social-login/redirect/{provider}', [SocialController::class, 'redirectLoginToProvider'])->name('social.login');
    Route::get('/social-login/{provider}/callback', [SocialController::class, 'handleProviderLoginCallback'])->name('social.login.callback');
    Route::get('/social-connect/redirect/{provider}', [SocialController::class, 'redirectConnectToProvider'])->name('social.connect');
    Route::get('/social-connect/{provider}/callback', [SocialController::class, 'handleProviderConnectCallback'])->name('social.connect.callback');

    Route::get('/search?q={search}', [HomeController::class, 'search'])->name('suggestion.search');
    Route::post('/ajax-search', [HomeController::class, 'ajax_search'])->name('search.ajax');

    // Route::get('/search', [HomeController::class, 'search'])->name('search');

    // Products
    Route::get('/product/{slug}', [ProductController::class, 'show'])->name(Product::getRouteName());
    Route::get('/product/{slug}/content', [ProductController::class, 'show_unlockable_content'])->name(Product::getRouteName() . '.unlockable_content')->middleware('purchased_or_owner');
    Route::get('/product/{id}/checkout-link', [ProductController::class, 'createProductCheckoutRedirect'])->name('product.generate_checkout_link');
    // Route::get('/course/item/{slug}', [ProductController::class, 'course_item_show'])->name(CourseItem::getRouteName());
    Route::get('/product/{product_slug}/course/item/{slug}', [ProductController::class, 'course_item_show'])->name(CourseItem::getRouteName());

    Route::get('/plan/{slug}', [EVPlanController::class, 'show'])->name(Plan::getRouteName());
    Route::get('/plan/{id}/checkout-link', [EVPlanController::class, 'createPlanCheckoutRedirect'])->name('plan.generate_checkout_link');


    // Category archive pages
    Route::get('/category/{slug}', [EVCategoryController::class, 'archiveByCategory'])->where('slug', '.+')->name('category.index');
    Route::get('/products/category/{slug}', [ProductController::class, 'productsByCategory'])->where('slug', '.+')->name('category.products.index');
    Route::get('/products', [ProductController::class, 'productsByCategory'])->where('slug', '.+')->name('products.all');
    Route::get('/products/brand/{brand_slug}', [HomeController::class, 'listingByBrand'])->name('products.brand');

    // Users/Shops single page
    Route::get('/users/{id}', [EVAccountController::class, 'frontend_user_profile'])->name('user.profile.single');

    // Blog Posts
    Route::group([], base_path('routes/tenant/blog-posts-group.php'));


    // Social Posts
    Route::get('/social/post/{id}', [BlogPostController::class, 'social_post_single'])->name('social.post.single');

    // Shop pages
    Route::get('/shop/{slug}', [EVShopController::class, 'single'])->name(Shop::getRouteName());
    Route::get('/shops', [MerchantController::class, 'index'])->name('shop.index');
    // Route::get('/shop/{slug}/info/{sub_page}', [CompanyController::class, 'show'])->name('shop.sub-page');
    Route::get('/shop/{slug}/{type}', [HomeController::class, 'filter_shop'])->name('shop.visit.type');

    // Cart page
    Route::get('/cart', [EVCartController::class, 'index'])->name('cart');
    Route::get('/wishlist', [EVWishlistController::class, 'index'])->name('wishlist');
    Route::get('/wishlist/views', [EVWishlistController::class, 'views'])->name('wishlist.views');

    // Checkout Routes
    Route::middleware('checkout')->group(function () {
        Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
        Route::post('/checkout', [CheckoutController::class, 'process_checkout'])->name('checkout.process');

        // Execute payment routes
        Route::post('/checkout/execute/payment/{invoice_id}', [CheckoutController::class, 'executePayment'])->name('checkout.execute.payment');
        Route::get('/checkout/execute/payment/{invoice_id}/{payment_gateway}', [CheckoutController::class, 'executePayment'])->name('checkout.execute.custom.payment');
        Route::post('/checkout/execute/payment/{invoice_id}/{payment_gateway}', [CheckoutController::class, 'executePayment'])->name('checkout.execute.custom.payment.post');

        // Paysera callback routes
        Route::get('/checkout/paysera/accepted/{invoice_id}', [PayseraGateway::class, 'accepted'])->name('gateway.paysera.accepted');
        Route::get('/checkout/paysera/canceled/{invoice_id}', [PayseraGateway::class, 'canceled'])->name('gateway.paysera.canceled');
        Route::get('/checkout/paysera/callback/{invoice_id}', [PayseraGateway::class, 'callback'])->name('gateway.paysera.callback');

        Route::get('/order/{id}/canceled', [CheckoutController::class, 'orderCanceled'])->name('checkout.order.canceled');
        Route::get('/order/{id}/paid', [CheckoutController::class, 'orderPaid'])->name('checkout.order.paid');
    });
    Route::get('/order/{id}/received', [CheckoutController::class, 'orderReceived'])->name('checkout.order.received');
    Route::get('/request-quote', [QuotesController::class, 'create'])->name('quote.create');
    Route::get('/request-quote/{id}/received', [QuotesController::class, 'quoteReceived'])->name('quote.received');

    /* Old active commerce stripe routes */
    Route::get('stripe', [StripePaymentController::class, 'stripe']);
    Route::post('/stripe/create-checkout-session', [StripePaymentController::class, 'stripe'])->name('stripe.get_token');
    Route::get('/stripe/create-portal-session', [StripePaymentController::class, 'createPortalSession'])->name('stripe.portal_session');
    Route::any('/stripe/payment/callback', [StripePaymentController::class, 'callback'])->name('stripe.callback');
    Route::get('/stripe/success', [StripePaymentController::class, 'success'])->name('stripe.success');
    Route::get('/stripe/cancel', [StripePaymentController::class, 'cancel'])->name('stripe.cancel');
    //Stripe END

    // Route::resource('subscribers', 'SubscriberController');
    /* TODO: Move some logic to brand, category, seller controllers as home controller holds too much logic*/
    Route::get('/brands', [HomeController::class, 'all_brands'])->name('brands.all');
    Route::get('/categories', [HomeController::class, 'all_categories'])->name('categories.all');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');

    // Tenant Management routes - added from SaaS Boilerplate
    Route::get('/impersonate/{token}', function ($token) {
        return UserImpersonation::makeResponse($token);
    })->name('tenant.impersonate');

    Route::middleware(OwnerOnly::class)->group(function () {
        Route::get('/settings/application', [ApplicationSettingsController::class, 'show'])->name('tenant.settings.application');
        Route::post('/settings/application/configuration', [ApplicationSettingsController::class, 'storeConfiguration'])->name('tenant.settings.application.configuration');
        Route::get('/settings/application/invoice/{id}/download', [DownloadInvoiceController::class])->name('tenant.invoice.download');
    });

    Route::get('/integrations/pix', [PixProLicenseController::class, 'index']);

    //Custom page
    // Route::get('/page/privacy-policy', [\App\Http\Controllers\PageController::class, 'privacy_policy_page'])->name('custom-pages.privacy-policy');

});

/**
 * Tenant API Routes
 */
Route::middleware([
    'api',
    InitializeTenancyByDomainAndVendorDomains::class,
    VendorMode::class,
])->prefix('api')->name('api.')->group(function () {
    // Quizz Result Save
    Route::post('/we-quizz-result/{id}', [WeQuizController::class, 'save_result'])->name('we-quiz.result.save');
    Route::get('/validate/vat', [EVAccountController::class, 'validateVAT'])->name('validate.vat');

    // TODO: Make these api Routes PROTECTED by AUTH!
    Route::middleware('auth')->group(function () {
    });

});

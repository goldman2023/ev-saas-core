<?php

use App\Http\Controllers\AffiliateBannerController;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\CompareController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\CustomerProductController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EVSaaSController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\StripePaymentController;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
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


Route::get('/ev-tenant/create', [EVSaaSController::class, 'create']);

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->namespace('App\Http\Controllers')->group(function () {
    Route::get('/tenant/info', [EVSaaSController::class, 'info']);
    //Home Page
    Route::get('/', [HomeController::class, 'index'])->name('home');

    //category dropdown menu ajax call
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


    Auth::routes(['verify' => true]);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/email/resend', [VerificationController::class, 'resend'])->name('email.verification.resend');
    Route::get('/verification-confirmation/{code}', [VerificationController::class, 'verification_confirmation'])->name('email.verification.confirmation');
    Route::get('/email_change/callback', [HomeController::class, 'email_change_callback'])->name('email_change.callback');
    Route::post('/password/reset/email/submit', [HomeController::class, 'reset_password_with_code'])->name('user.password.update');


    Route::post('/language', [LanguageController::class, 'changeLanguage'])->name('language.change');
    Route::post('/currency', [CurrencyController::class, 'changeCurrency'])->name('currency.change');

    Route::get('/social-login/redirect/{provider}', [LoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('/social-login/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('social.callback');
    Route::get('/users/login', [HomeController::class, 'login'])->name('user.login');
    Route::get('/users/registration', [HomeController::class, 'registration'])->name('user.registration');
    Route::post('/users/login', [HomeController::class, 'user_login'])->name('user.login.submit');
    Route::post('/users/login/cart', [HomeController::class, 'cart_login'])->name('cart.login.submit');


    Route::get('/customer-products', [CustomerProductController::class, 'customer_products_listing'])->name('customer.products');
    Route::get('/customer-products?category={category_slug}', [CustomerProductController::class, 'search'])->name('customer_products.category');
    Route::get('/customer-products?city={city_id}', [CustomerProductController::class, 'search'])->name('customer_products.city');
    Route::get('/customer-products?q={search}', [CustomerProductController::class, 'search'])->name('customer_products.search');
    Route::get('/customer-products/admin', [HomeController::class, 'profile_edit'])->name('customer.profile.edit');
    Route::get('/customer-product/{slug}', [CustomerProductController::class, 'customer_product'])->name('customer.product');
    Route::get('/customer-packages', [HomeController::class, 'premium_package_index'])->name('customer_packages_list_show');

    Route::get('/search', [HomeController::class, 'search'])->name('search');
    Route::get('/search?q={search}', [HomeController::class, 'search'])->name('suggestion.search');
    Route::post('/ajax-search', [HomeController::class, 'ajax_search'])->name('search.ajax');

    Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');
    Route::get('/category/{category_slug}', [HomeController::class, 'listingByCategory'])->name('products.category');
    Route::get('/brand/{brand_slug}', [HomeController::class, 'listingByBrand'])->name('products.brand');
    Route::post('/product/variant_price', [HomeController::class, 'variant_price'])->name('products.variant_price');
    Route::get('/shop/{slug}', [HomeController::class, 'shop'])->name('shop.visit');
    Route::get('/shop/{slug}/info/{sub_page}', [CompanyController::class, 'show'])->name('shop.sub-page');
    Route::get('/shop/{slug}/{type}', [HomeController::class, 'filter_shop'])->name('shop.visit.type');
    Route::get('/event/{slug}', [EventController::class, 'show'])->name('event.visit');

    Route::get('/cart', [CartController::class, 'index'])->name('cart');
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

    Route::group(['middleware' => ['user', 'verified', 'unbanned']], function () {
        Route::get('/dashboard', 'HomeController@dashboard')->name('dashboard');
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

    Route::group(['middleware' => ['auth']], function () {
        Route::post('/products/store/', 'ProductController@store')->name('products.store');
        Route::post('/products/update/{id}', 'ProductController@update')->name('products.update');
        Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
        Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
        Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
        Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
        Route::post('/products/seller/featured', 'ProductController@updateSellerFeatured')->name('products.seller.featured');
        Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');

        Route::get('invoice/{order_id}', 'InvoiceController@invoice_download')->name('invoice.download');

        Route::resource('orders', 'OrderController')->parameters([
            'orders' => 'id',
        ])->except(['destroy']);
        Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
        Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
        Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
        Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');

        Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
        Route::get('/shop/{company_name}/review/create', 'ReviewController@create')->name('reviews.create');
        Route::post('/review/store', 'ReviewController@store')->name('reviews.store');
        Route::post('/review/published', 'ReviewController@updatePublished')->name('reviews.published');

        Route::resource('/withdraw_requests', 'SellerWithdrawRequestController');
        Route::get('/withdraw_requests_all', 'SellerWithdrawRequestController@request_index')->name('withdraw_requests_all');
        Route::post('/withdraw_request/payment_modal', 'SellerWithdrawRequestController@payment_modal')->name('withdraw_request.payment_modal');
        Route::post('/withdraw_request/message_modal', 'SellerWithdrawRequestController@message_modal')->name('withdraw_request.message_modal');

        Route::resource('conversations', 'ConversationController')->parameters([
            'conversations' => 'id',
        ]);
//    Route::get('/conversations/destroy/{id}', 'ConversationController@destroy')->name('conversations.destroy');
        Route::post('conversations/refresh', 'ConversationController@refresh')->name('conversations.refresh');
        Route::post('conversations/save', 'ConversationController@saveConversation')->name('conversations.save');

        Route::resource('messages', 'MessageController');

        //Product Bulk Upload
        Route::get('/product-bulk-upload/index', 'ProductBulkUploadController@index')->name('product_bulk_upload.index');
        Route::post('/bulk-product-upload', 'ProductBulkUploadController@bulk_upload')->name('bulk_product_upload');
        Route::get('/product-csv-download/{type}', 'ProductBulkUploadController@import_product')->name('product_csv.download');
        Route::get('/vendor-product-csv-download/{id}', 'ProductBulkUploadController@import_vendor_product')->name('import_vendor_product.download');
        Route::group(['prefix' => 'bulk-upload/download'], function () {
            Route::get('/category', 'ProductBulkUploadController@pdf_download_category')->name('pdf.download_category');
            Route::get('/brand', 'ProductBulkUploadController@pdf_download_brand')->name('pdf.download_brand');
            Route::get('/seller', 'ProductBulkUploadController@pdf_download_seller')->name('pdf.download_seller');
        });

        //Product Export
        Route::get('/product-bulk-export', 'ProductBulkUploadController@export')->name('product_bulk_export.index');

        Route::resource('digitalproducts', 'DigitalProductController')->parameters([
            'digitalproducts' => 'id',
        ])->except(['destroy']);
//    Route::get('/digitalproducts/edit/{id}', 'DigitalProductController@edit')->name('digitalproducts.edit');
        Route::get('/digitalproducts/destroy/{id}', 'DigitalProductController@destroy')->name('digitalproducts.destroy');
        Route::get('/digitalproducts/download/{id}', 'DigitalProductController@download')->name('digitalproducts.download');

        //Reports
        Route::get('/commission-log', 'ReportController@commission_history')->name('commission-log.index');

        //Document and Gallery
        Route::resource('documentgallery', 'DocumentGalleryController')->parameters([
            'documentgallery' => 'id',
        ])->except(['destroy']);
//    Route::get('/documentgallery/edit/{id}', 'DocumentGalleryController@edit')->name('documentgallery.edit');
//    Route::post('/documentgallery/update/{id}', 'DocumentGalleryController@update')->name('documentgallery.update');
        Route::get('/documentgallery/destroy/{id}', 'DocumentGalleryController@destroy')->name('documentgallery.destroy');

        //Notifications
        Route::resource('notifications', 'NotificationController');
        Route::post('/notifications/mark-all-as-read', 'NotificationController@markAllAsRead')->name('notifications.mark_all_as_read');


        //Events
        Route::resource('events', 'EventController')->parameters([
            'events' => 'id',
        ])->except(['show', 'index', 'destroy']);
        Route::get('/events', 'EventController@all_events')->name('events');
        Route::get('/events/{slug}', 'EventController@show')->name('event.show');
        Route::get('/events/category/{category_slug}', 'EventController@listingByCategory')->name('events.category');
//    Route::post('/events/update/{id}', 'EventController@update')->name('event.update');
        Route::get('/events/destroy/{id}', 'EventController@destroy')->name('event.destroy');


        // Jobs
        Route::resource('jobs', 'JobController')->parameters([
            'jobs' => 'id',
        ])->except(['destroy']);
//    Route::post('/jobs/store', 'JobController@store')->name('jobs.store');
//    Route::post('/jobs/update/{id}', 'JobController@update')->name('jobs.update');
        Route::get('/jobs/destroy/{id}', 'JobController@destroy')->name('jobs.destroy');

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
    Route::get('/early-bird', 'PageController@early_bird')->name('landing.early-bird');
    Route::get('/pricing', 'PageController@pricing')->name('landing.pricing');

//Custom page
    Route::get('/{slug}', 'PageController@show_custom_page')->name('custom-pages.show_custom_page');


// Mailchimp subscriptions routes
    Route::post('/subscribe/{type}', 'Integrations\MailchimpController@subscribe')
        ->name('mailchimp.subscribe');

    Route::get('/page/{slug}', 'PageController@show_static_page')->name('page.static_page');

// Get Stream Integration routes
    Route::get('/feed/all', 'Integrations\GetStreamControler@index');


    //Checkout Routes
    Route::group(['middleware' => ['checkout']], function () {
        Route::get('/checkout', 'CheckoutController@get_shipping_info')->name('checkout.shipping_info');
        Route::any('/checkout/delivery_info', 'CheckoutController@store_shipping_info')->name('checkout.store_shipping_infostore');
        Route::post('/checkout/payment_select', 'CheckoutController@store_delivery_info')->name('checkout.store_delivery_info');
    });
});

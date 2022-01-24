<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\EVAccountController;
use App\Http\Controllers\EVCheckoutController;
use App\Http\Controllers\EVOrderController;
use App\Http\Controllers\EVProductController;
use App\Http\Controllers\Integrations\FacebookBusinessController;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;
use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Models\User;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\VendorMode;
use Illuminate\Support\Facades\Route;


Route::middleware([
    'web',
    'universal',
    InitializeTenancyByDomainAndVendorDomains::class,
    PreventAccessFromCentralDomains::class,
    VendorMode::class,
])->namespace('App\Http\Controllers')->group(function () {

    /* TODO: Make this dashboard group for routes, to prefix for /orders /products etc, to be /dashboard/products / dashboard/orders/ ... */

    Route::group([
        'middleware' => ['auth'],
        'prefix' => 'dashboard'
    ], function () {
        Route::get('/index', 'HomeController@dashboard')->name('dashboard');


        /* TODO : Admin only */

        /* Leads Management - BY EIM */
        Route::get('leads/success', 'LeadController@success')->name('leads.success');
        Route::resource('leads', 'LeadController');

        /* TODO: Admin only */
        Route::get('/ev-activity', [ActivityController::class, 'index_frontend'])->name('activity.index');



        /* TODO: Admin and seller only */

        // ---------------------------------------------------- //

        /* Products */
        Route::get('/ev-products', [EVProductController::class, 'index'])->name('ev-products.index');
        Route::get('/ev-products/create', [EVProductController::class, 'create'])->name('ev-products.create');
        Route::get('/ev-products/edit/{slug}', [EVProductController::class, 'edit'])->name('ev-products.edit');
        Route::get('/ev-products/edit/{slug}/details', [EVProductController::class, 'product_details'])->name('ev-products.details');
        Route::get('/ev-products/edit/{slug}/details/activity', [EVProductController::class, 'product_activity'])->name('ev-products.activity');
        Route::get('/ev-products/edit/{slug}/variations', [EVProductController::class, 'edit_variations'])->name('ev-products.edit.variations');
        Route::get('/ev-products/edit/{slug}/stock-management', [EVProductController::class, 'edit_stocks'])->name('ev-products.edit.stocks');

        /* Orders */
        Route::get('/orders', [EVOrderController::class, 'index'])->name('orders.index');
        Route::get('/order/create', [EVOrderController::class, 'create'])->name('order.create');
        Route::get('/order/view/{id}', [EVOrderController::class, 'details'])->name('order.details');
//        Route::resource('orders', 'EVOrderController')->parameters([
//            'orders' => 'id',
//        ])->except(['destroy']);
       Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');
       Route::post('/orders/details', 'OrderController@order_details')->name('orders.details');
       Route::post('/orders/update_delivery_status', 'OrderController@update_delivery_status')->name('orders.update_delivery_status');
       Route::post('/orders/update_payment_status', 'OrderController@update_payment_status')->name('orders.update_payment_status');

        /* My Purchases/Wishlist/Viewed Items */
        Route::get('/purchases/all', [EVOrderController::class, 'my_purchases'])->name('my.purchases.all');

        /* My account */
        Route::get('/account-settings', [EVAccountController::class, 'account_settings'])->name('my.account.settings');
        Route::get('/profile/{id}', [EVAccountController::class, 'user_profile'])->name('user.profile');

        /* Settings pages*/
        Route::get('/ev-design-settings', [EVAccountController::class, 'design_settings'])->name('settings.design');
        Route::post('/ev-design-settings', [EVAccountController::class, 'design_settings_store'])->name('settings.design.store');
        Route::get('/ev-payment-methods-settings', [EVAccountController::class, 'payment_methods_settings'])->name('settings.payment_methods');
        Route::get('/domain-settings', [EVAccountController::class, 'domain_settings'])->name('settings.domains');
        Route::get('/staff-settings', [EVAccountController::class, 'staff_settings'])->name('settings.staff_settings');
        Route::get('/shop-settings', [EVAccountController::class, 'shop_settings'])->name('settings.shop_settings');


// Payment Methods callback routes
        Route::get('/checkout/paysera/accepted/{id}', [PayseraGateway::class, 'accepted'])->name('gateway.paysera.accepted');
        Route::get('/checkout/paysera/canceled/{id}', [PayseraGateway::class, 'canceled'])->name('gateway.paysera.canceled');
        Route::get('/checkout/paysera/callback/{id}', [PayseraGateway::class, 'callback'])->name('gateway.paysera.callback');

        Route::post('/checkout/execute/payment/{id}', [EVCheckoutController::class, 'executePayment'])->name('checkout.execute.payment');
// ---------------------------------------------------- //

        Route::post('/products/store/', 'ProductController@store')->name('products.store');
        Route::post('/products/update/{id}', 'ProductController@update')->name('products.update');
        Route::get('/products/destroy/{id}', 'ProductController@destroy')->name('products.destroy');
        Route::get('/products/duplicate/{id}', 'ProductController@duplicate')->name('products.duplicate');
        Route::post('/products/sku_combination', 'ProductController@sku_combination')->name('products.sku_combination');
        Route::post('/products/sku_combination_edit', 'ProductController@sku_combination_edit')->name('products.sku_combination_edit');
        Route::post('/products/seller/featured', 'ProductController@updateSellerFeatured')->name('products.seller.featured');
        Route::post('/products/published', 'ProductController@updatePublished')->name('products.published');

        Route::get('invoice/{order_id}', 'InvoiceController@invoice_download')->name('invoice.download');



        Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
        /* TODO: Create new route for adding reviews for products, now this route is reviews for companies */
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


    // Integrations
    Route::get('/integrations', 'Integrations\IntegrationsController@index')->name('integrations.index');

    Route::get('/integrations/facebook-business-export', 'Integrations\FacebookBusinessController@export')->name('integrations.facebook-business.export');



});

<?php

/*
  |--------------------------------------------------------------------------
  | Admin Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register admin routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */


use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {


    Route::get('/admin', 'HomeController@admin_dashboard')->name('admin.dashboard')->middleware(['auth', 'admin']);

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'admin']], function () {
        // Activities
        Route::get('/activities/', 'ActivityController@index')->name('activities.index');
        Route::get('/my-activities/', 'ActivityController@user_activity')->name('activities.user.index');

        //Update Routes
        Route::resource('categories', 'CategoryController')->parameters([
            'categories' => 'id',
        ])->except(['destroy']);
        //Route::get('/categories/edit/{id}', 'CategoryController@edit')->name('categories.edit');
        Route::get('/categories/destroy/{id}', 'CategoryController@destroy')->name('categories.destroy');
        Route::post('/categories/featured', 'CategoryController@updateFeatured')->name('categories.featured');

        Route::resource('brands', 'BrandController')->parameters([
            'brands' => 'id',
        ])->except(['destroy']);
//    Route::get('/brands/edit/{id}', 'BrandController@edit')->name('brands.edit');
        Route::get('/brands/destroy/{id}', 'BrandController@destroy')->name('brands.destroy');

        Route::get('/products/admin', 'ProductController@admin_products')->name('products');
        Route::get('/products/seller', 'ProductController@seller_products')->name('products.seller');
        Route::get('/products/all', 'ProductController@all_products')->name('products.all');
        Route::get('/products/create', 'ProductController@create')->name('products.create');
        Route::get('/products/admin/{id}/edit', 'ProductController@admin_product_edit')->name('products.edit');
        Route::get('/products/seller/{id}/edit', 'ProductController@seller_product_edit')->name('products.seller.edit');
        Route::post('/products/todays_deal', 'ProductController@updateTodaysDeal')->name('products.todays_deal');
        Route::post('/products/featured', 'ProductController@updateFeatured')->name('products.featured');
        Route::post('/products/get_products_by_subcategory', 'ProductController@get_products_by_subcategory')->name('products.get_products_by_subcategory');

        //Seller DataTables
        Route::get('sellers/data-table', 'SellerController@index_data_table')->name('sellers.index.data-table');

        Route::resource('sellers', 'SellerController')->parameters([
            'sellers' => 'id',
        ])->except(['destroy']);
        Route::get('sellers_ban/{id}', 'SellerController@ban')->name('sellers.ban');
        Route::get('/sellers/destroy/{id}', 'SellerController@destroy')->name('sellers.destroy');
        Route::get('/sellers/documentgallery/{id}', 'DocumentGalleryController@seller_document_gallery')->name('sellers.documentgallery');
        Route::get('/sellers/documentgallery/edit/{id}', 'DocumentGalleryController@seller_document_gallery_edit')->name('sellers.documentgallery.edit');
        Route::get('/sellers/view/{id}/verification', 'SellerController@show_verification_request')->name('sellers.show_verification_request');
        Route::get('/sellers/approve/{id}', 'SellerController@approve_seller')->name('sellers.approve');
        Route::get('/sellers/reject/{id}', 'SellerController@reject_seller')->name('sellers.reject');
        Route::get('/sellers/login/{id}', 'SellerController@login')->name('sellers.login');
        Route::post('/sellers/payment_modal', 'SellerController@payment_modal')->name('sellers.payment_modal');
        Route::get('/seller/payments', 'PaymentController@payment_histories')->name('sellers.payment_histories');
        Route::get('/seller/payments/show/{id}', 'PaymentController@show')->name('sellers.payment_history');
        Route::get('/seller/attributes/show/{id}', 'AttributeController@attribute_history')->name('sellers.attribute_history');

        Route::resource('customers', 'CustomerController')->parameters([
            'customers' => 'id',
        ])->except(['destroy']);
        Route::get('customers_ban/{customer}', 'CustomerController@ban')->name('customers.ban');
        Route::get('/customers/login/{id}', 'CustomerController@login')->name('customers.login');
        Route::get('/customers/destroy/{id}', 'CustomerController@destroy')->name('customers.destroy');

        Route::get('/newsletter', 'NewsletterController@index')->name('newsletters.index');
        Route::post('/newsletter/send', 'NewsletterController@send')->name('newsletters.send');
        Route::post('/newsletter/test/smtp', 'NewsletterController@testEmail')->name('test.smtp');

        Route::resource('profile', 'ProfileController')->parameters([
            'profile' => 'id',
        ]);

        Route::post('/business-settings/update', 'TenantSettingsController@update')->name('tenant_settings.update');
        Route::post('/business-settings/update/activation', 'TenantSettingsController@updateActivationSettings')->name('tenant_settings.update.activation');
        Route::get('/general-setting', 'TenantSettingsController@general_setting')->name('general_setting.index');
        Route::get('/checkout-flow', 'TenantSettingsController@checkout_flow')->name('checkout_flow.index');
        Route::get('/activation', 'TenantSettingsController@activation')->name('activation.index');
        Route::get('/payment-method', 'TenantSettingsController@payment_method')->name('payment_method.index');
        Route::get('/file_system', 'TenantSettingsController@file_system')->name('file_system.index');
        Route::get('/social-login', 'TenantSettingsController@social_login')->name('social_login.index');
        Route::get('/smtp-settings', 'TenantSettingsController@smtp_settings')->name('smtp_settings.index');
        Route::get('/google-analytics', 'TenantSettingsController@google_analytics')->name('google_analytics.index');
        Route::get('/google-recaptcha', 'TenantSettingsController@google_recaptcha')->name('google_recaptcha.index');

        //Facebook Settings
        Route::get('/facebook-chat', 'TenantSettingsController@facebook_chat')->name('facebook_chat.index');
        Route::post('/facebook_chat', 'TenantSettingsController@facebook_chat_update')->name('facebook_chat.update');
        Route::get('/facebook-comment', 'TenantSettingsController@facebook_comment')->name('facebook-comment');
        Route::post('/facebook-comment', 'TenantSettingsController@facebook_comment_update')->name('facebook-comment.update');
        Route::post('/facebook_pixel', 'TenantSettingsController@facebook_pixel_update')->name('facebook_pixel.update');

        Route::post('/env_key_update', 'TenantSettingsController@env_key_update')->name('env_key_update.update');
        Route::post('/payment_method_update', 'TenantSettingsController@payment_method_update')->name('payment_method.update');
        Route::post('/google_analytics', 'TenantSettingsController@google_analytics_update')->name('google_analytics.update');
        Route::post('/google_recaptcha', 'TenantSettingsController@google_recaptcha_update')->name('google_recaptcha.update');

        //Currency
        Route::get('/currency', 'CurrencyController@currency')->name('currency.index');
        Route::post('/currency/update', 'CurrencyController@updateCurrency')->name('currency.update');
        Route::post('/your-currency/update', 'CurrencyController@updateYourCurrency')->name('your_currency.update');
        Route::get('/currency/create', 'CurrencyController@create')->name('currency.create');
        Route::post('/currency/store', 'CurrencyController@store')->name('currency.store');
        Route::post('/currency/currency_edit', 'CurrencyController@edit')->name('currency.edit');
        Route::post('/currency/update_status', 'CurrencyController@update_status')->name('currency.update_status');

        //Tax
        Route::resource('tax', 'TaxController')->parameters([
            'tax' => 'id',
        ])->except(['destroy']);
//    Route::get('/tax/edit/{id}', 'TaxController@edit')->name('tax.edit');
        Route::get('/tax/destroy/{id}', 'TaxController@destroy')->name('tax.destroy');
        Route::post('tax-status', 'TaxController@change_tax_status')->name('taxes.tax-status');


        Route::get('/verification/form', 'TenantSettingsController@seller_verification_form')->name('seller_verification_form.index');
        Route::post('/verification/form', 'TenantSettingsController@seller_verification_form_update')->name('seller_verification_form.update');
        Route::get('/vendor_commission', 'TenantSettingsController@vendor_commission')->name('tenant_settings.vendor_commission');
        Route::post('/vendor_commission_update', 'TenantSettingsController@vendor_commission_update')->name('tenant_settings.vendor_commission.update');

        Route::resource('languages', 'LanguageController')->parameters([
            'languages' => 'id',
        ])->except(['destroy']);
//    Route::post('/languages/{id}/update', 'LanguageController@update')->name('languages.update');
        Route::get('/languages/destroy/{id}', 'LanguageController@destroy')->name('languages.destroy');
        Route::post('/languages/update_rtl_status', 'LanguageController@update_rtl_status')->name('languages.update_rtl_status');
        Route::post('/languages/key_value_store', 'LanguageController@key_value_store')->name('languages.key_value_store');


        // SEO setting
        Route::get('/seo', 'TenantSettingsController@seo_setting')->name('seo.index');
        Route::post('/seo/update_seo_setting', 'TenantSettingsController@update_seo_setting')->name('seo.update_seo_setting');

        // website setting
        Route::group(['prefix' => 'website'], function () {
            Route::view('/header', 'backend.website_settings.header')->name('website.header');
            Route::view('/footer', 'backend.website_settings.footer')->name('website.footer');
            Route::view('/pages', 'backend.website_settings.pages.index')->name('website.pages');
            Route::view('/appearance', 'backend.website_settings.appearance')->name('website.appearance');
            Route::resource('custom-pages', 'PageController')->parameters([
                'custom-pages' => 'id',
            ])->except(['destroy']);
//        Route::get('/custom-pages/edit/{id}', 'PageController@edit')->name('custom-pages.edit');
            Route::get('/custom-pages/destroy/{id}', 'PageController@destroy')->name('custom-pages.destroy');
        });

        Route::resource('roles', 'RoleController')->parameters([
            'roles' => 'id',
        ])->except(['destroy']);
//    Route::get('/roles/edit/{id}', 'RoleController@edit')->name('roles.edit');
        Route::get('/roles/destroy/{id}', 'RoleController@destroy')->name('roles.destroy');

        Route::resource('staffs', 'StaffController')->parameters([
            'staffs' => 'id',
        ])->except(['destroy']);
        Route::get('/staffs/destroy/{id}', 'StaffController@destroy')->name('staffs.destroy');

        // Affiliate Banner
        Route::resource('affiliate_banner', 'AffiliateBannerController')->parameters([
            'affiliate_banner' => 'id',
        ])->except(['destroy']);
//    Route::get('/affiliate_banner/edit/{id}', 'AffiliateBannerController@edit')->name('affiliate_banner.edit');
        Route::get('/affiliate_banner/destroy/{id}', 'AffiliateBannerController@destroy')->name('affiliate_banner.destroy');


        Route::resource('flash_deals', 'FlashDealController')->parameters([
            'flash_deals' => 'id',
        ])->except(['destroy']);
//    Route::get('/flash_deals/edit/{id}', 'FlashDealController@edit')->name('flash_deals.edit');
        Route::get('/flash_deals/destroy/{id}', 'FlashDealController@destroy')->name('flash_deals.destroy');
        Route::post('/flash_deals/update_status', 'FlashDealController@update_status')->name('flash_deals.update_status');
        Route::post('/flash_deals/update_featured', 'FlashDealController@update_featured')->name('flash_deals.update_featured');
        Route::post('/flash_deals/product_discount', 'FlashDealController@product_discount')->name('flash_deals.product_discount');
        Route::post('/flash_deals/product_discount_edit', 'FlashDealController@product_discount_edit')->name('flash_deals.product_discount_edit');

        //Subscribers
        Route::get('/subscribers', 'SubscriberController@index')->name('subscribers.index');
        Route::get('/subscribers/destroy/{id}', 'SubscriberController@destroy')->name('subscriber.destroy');

        // Route::get('/orders', 'OrderController@admin_orders')->name('orders.index.admin');
        // Route::get('/orders/{id}/show', 'OrderController@show')->name('orders.show');
        // Route::get('/sales/{id}/show', 'OrderController@sales_show')->name('sales.show');
        // Route::get('/sales', 'OrderController@sales')->name('sales.index');

        // All Orders
        Route::get('/all_orders', 'OrderController@all_orders')->name('all_orders.index');
        Route::get('/all_orders/{id}/show', 'OrderController@all_orders_show')->name('all_orders.show');

        // Inhouse Orders
        Route::get('/inhouse-orders', 'OrderController@admin_orders')->name('inhouse_orders.index');
        Route::get('/inhouse-orders/{id}/show', 'OrderController@show')->name('inhouse_orders.show');

        // Seller Orders
        Route::get('/seller_orders', 'OrderController@seller_orders')->name('seller_orders.index');
        Route::get('/seller_orders/{id}/show', 'OrderController@seller_orders_show')->name('seller_orders.show');

        // Pickup point orders
        Route::get('orders_by_pickup_point', 'OrderController@pickup_point_order_index')->name('pick_up_point.order_index');
        Route::get('/orders_by_pickup_point/{id}/show', 'OrderController@pickup_point_order_sales_show')->name('pick_up_point.order_show');

        Route::get('/orders/destroy/{id}', 'OrderController@destroy')->name('orders.destroy');

        Route::post('/pay_to_seller', 'CommissionController@pay_to_seller')->name('commissions.pay_to_seller');

        //Reports
        Route::get('/stock_report', 'ReportController@stock_report')->name('stock_report.index');
        Route::get('/in_house_sale_report', 'ReportController@in_house_sale_report')->name('in_house_sale_report.index');
        Route::get('/seller_sale_report', 'ReportController@seller_sale_report')->name('seller_sale_report.index');
        Route::get('/wish_report', 'ReportController@wish_report')->name('wish_report.index');
        Route::get('/user_search_report', 'ReportController@user_search_report')->name('user_search_report.index');
        Route::get('/wallet-history', 'ReportController@wallet_transaction_history')->name('wallet-history.index');

        //Blog Section
        Route::resource('blog', 'BlogController')->parameters([
            'blog' => 'id',
        ])->except(['destroy']);
        Route::get('/blog/destroy/{id}', 'BlogController@destroy')->name('blog.destroy');
        Route::post('/blog/change-status', 'BlogController@change_status')->name('blog.change-status');

        //Coupons
        Route::resource('coupon', 'CouponController')->parameters([
            'coupon' => 'id',
        ])->except(['destroy']);
        Route::post('/coupon/get_form', 'CouponController@get_coupon_form')->name('coupon.get_coupon_form');
        Route::post('/coupon/get_form_edit', 'CouponController@get_coupon_form_edit')->name('coupon.get_coupon_form_edit');
        Route::get('/coupon/destroy/{id}', 'CouponController@destroy')->name('coupon.destroy');

        //Reviews
        Route::resource('reviews', 'ReviewController')->parameters([
            'reviews' => 'id',
        ]);
//    Route::get('/reviews', 'ReviewController@index')->name('reviews.index');
        Route::post('/reviews/published', 'ReviewController@updatePublished')->name('reviews.published');

        //Support_Ticket
        Route::get('support_ticket/', 'SupportTicketController@admin_index')->name('support_ticket.index');
        Route::get('support_ticket/{id}/show', 'SupportTicketController@admin_show')->name('support_ticket.show');
        Route::post('support_ticket/reply', 'SupportTicketController@admin_store')->name('support_ticket.store');

        //Pickup_Points
        Route::resource('pick_up_points', 'PickupPointController')->parameters([
            'pick_up_points' => 'id',
        ])->except(['destroy']);
//    Route::get('/pick_up_points/edit/{id}', 'PickupPointController@edit')->name('pick_up_points.edit');
        Route::get('/pick_up_points/destroy/{id}', 'PickupPointController@destroy')->name('pick_up_points.destroy');

        //conversation of seller customer
        Route::get('conversations', 'ConversationController@admin_index')->name('conversations.index');
        Route::get('conversations/{id}/show', 'ConversationController@admin_show')->name('conversations.show');

        Route::post('/sellers/profile_modal', 'SellerController@profile_modal')->name('sellers.profile_modal');
        Route::post('/sellers/approved', 'SellerController@updateApproved')->name('sellers.approved');

        Route::resource('attributes', 'AttributeController')->parameters([
            'attributes' => 'id',
        ])->except(['destroy', 'show']);
        Route::get('/attributes/destroy/{id}', 'AttributeController@destroy')->name('attributes.destroy');
        Route::get('/attributes/{slug}', 'AttributeController@slug_index')->name('attributes.slug_index');
//    Route::get('/attributes/edit/{id}', 'AttributeController@edit')->name('attributes.edit');


        Route::resource('attribute_value', 'AttributeValueController')->parameters([
            'attribute_value' => 'id',
        ])->except(['destroy']);
//    Route::get('/attribute_value/edit/{id}', 'AttributeValueController@edit')->name('attribute_value.edit');
        Route::get('/attribute_value/destroy/{id}', 'AttributeValueController@destroy')->name('attribute_value.destroy');

        Route::resource('addons', 'AddonController');
        Route::post('/addons/activation', 'AddonController@activation')->name('addons.activation');

        Route::get('/customer-bulk-upload/index', 'CustomerBulkUploadController@index')->name('customer_bulk_upload.index');
        Route::post('/bulk-user-upload', 'CustomerBulkUploadController@user_bulk_upload')->name('bulk_user_upload');
        Route::post('/bulk-customer-upload', 'CustomerBulkUploadController@customer_bulk_file')->name('bulk_customer_upload');
        Route::get('/user', 'CustomerBulkUploadController@pdf_download_user')->name('pdf.download_user');

        //Customer Package
        Route::resource('customer_packages', 'CustomerPackageController')->parameters([
            'customer_packages' => 'id',
        ])->except('destroy');
        Route::get('/customer_packages/destroy/{id}', 'CustomerPackageController@destroy')->name('customer_packages.destroy');
//    Route::get('/customer_packages/edit/{id}', 'CustomerPackageController@edit')->name('customer_packages.edit');


        //Classified Products
        Route::get('/classified_products', 'CustomerProductController@customer_product_index')->name('classified_products');
        Route::post('/classified_products/published', 'CustomerProductController@updatePublished')->name('classified_products.published');

        //Shipping Configuration
        Route::get('/shipping_configuration', 'TenantSettingsController@shipping_configuration')->name('shipping_configuration.index');
        Route::post('/shipping_configuration/update', 'TenantSettingsController@shipping_configuration_update')->name('shipping_configuration.update');

        // Route::resource('pages', 'PageController');
        // Route::get('/pages/destroy/{id}', 'PageController@destroy')->name('pages.destroy');

        Route::resource('countries', 'CountryController');
        Route::post('/countries/status', 'CountryController@updateStatus')->name('countries.status');

        Route::resource('cities', 'CityController')->parameters([
            'cities' => 'id',
        ])->except(['destroy']);
//    Route::get('/cities/edit/{id}', 'CityController@edit')->name('cities.edit');
        Route::get('/cities/destroy/{id}', 'CityController@destroy')->name('cities.destroy');

        Route::view('/system/update', 'backend.system.update')->name('system_update');
        Route::view('/system/server-status', 'backend.system.server_status')->name('system_server');

        // uploaded files
        Route::any('/uploaded-files/file-info', 'AizUploadController@file_info')->name('uploaded-files.info');
        Route::resource('uploaded-files', 'AizUploadController')->parameters([
            'uploaded-files' => 'id',
        ])->except(['destroy']);
        Route::get('/uploaded-files/destroy/{id}', 'AizUploadController@destroy')->name('uploaded-files.destroy');

        //events
        Route::resource('events', 'EventController')->parameters([
            'events' => 'id',
        ])->except(['destroy']);
        Route::get('/events/login/{id}', 'EventController@login')->name('events.login');
        Route::get('/events/destroy/{id}', 'EventController@destroy')->name('events.destroy');
//    Route::get('/events/create', 'EventController@create')->name('events.create');
//    Route::get('/events/{id}/edit', 'EventController@edit')->name('events.edit');

        //Jobs
        Route::resource('jobs', 'JobController')->parameters([
            'jobs' => 'id',
        ])->except(['destroy']);
        Route::get('/jobs/destroy/{id}', 'JobController@destroy')->name('jobs.destroy');
//    Route::get('/jobs/create', 'JobController@create')->name('jobs.create');
//    Route::get('/jobs/{id}/edit', 'JobController@edit')->name('jobs.edit');
    });

});

<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\App;
use App\Http\Controllers\EVAccountController;
use App\Http\Controllers\EVAttributesController;
use App\Http\Controllers\EVBlogPostController;
use App\Http\Controllers\EVCategoryController;
use App\Http\Controllers\EVCheckoutController;
use App\Http\Controllers\EVOrderController;
use App\Http\Controllers\EVPageController;
use App\Http\Controllers\EVPlanController;
use App\Http\Controllers\EVProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Integrations\FacebookBusinessController;
use App\Http\Controllers\WeMediaController;
use App\Http\Middleware\InitializeTenancyByDomainAndVendorDomains;
use App\Http\Middleware\SetDashboard;
use App\Http\Middleware\VendorMode;
use App\Http\Services\PaymentMethods\PayseraGateway;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomainAndVendorDomains::class,
    PreventAccessFromCentralDomains::class,
    SetDashboard::class,
    VendorMode::class,
])->group(function () {
    Route::middleware('auth')->prefix('previews')->group(function () {
        Route::get('/show', [App\Http\Controllers\EVPreviewController::class, 'show'])->name('show');
    });

    /* TODO: Admin only */
    Route::middleware('auth', 'admin')->prefix('dashboard')->group(function () {
        // Categories
        Route::get('/categories', [EVCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/create', [EVCategoryController::class, 'create'])->name('category.create');
        Route::get('/categories/edit/{id}', [EVCategoryController::class, 'edit'])->name('category.edit');

        // Tenant blog posts
        //        Route::get('/tenant/blog/posts', [EVProductController::class, 'index'])->name('blog-posts.index');
        //        Route::get('/tenant/blog/posts/create', [EVProductController::class, 'create'])->name('blog-posts.create');
        //        Route::get('/tenant/blog/posts/edit/{slug}', [EVProductController::class, 'edit'])->name('blog-posts.edit');
    });

    /* TODO: Make this dashboard group for routes, to prefix for /orders /products etc, to be /dashboard/products / dashboard/orders/ ... */

    Route::middleware('auth')->prefix('dashboard')->group(function () {
        Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

        /* Leads Management - BY EIM */
        Route::get('leads/success', [\App\Http\Controllers\LeadController::class, 'success'])->name('leads.success');
        Route::resource('leads', 'LeadController');

        Route::get('/ev-activity', [ActivityController::class, 'index_frontend'])->name('activity.index');

        /* TODO: Admin and seller only */

        // ---------------------------------------------------- //

        /* Products */
        Route::get('/products', [EVProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [EVProductController::class, 'create2'])->name('product.create');
        // Route::get('/ev-products/create', [EVProductController::class, 'create'])->name('product.create');
        Route::get('/products/edit/{slug}', [EVProductController::class, 'edit'])->name('product.edit');
        Route::get('/products/edit/{slug}/details', [EVProductController::class, 'product_details'])->name('product.details');
        Route::get('/products/edit/{slug}/details/activity', [EVProductController::class, 'product_activity'])->name('product.activity');
        Route::get('/products/edit/{slug}/variations', [EVProductController::class, 'edit_variations'])->name('product.edit.variations');
        Route::get('/products/edit/{slug}/stock-management', [EVProductController::class, 'edit_stocks'])->name('product.edit.stocks');

        /* Pages */
        Route::get('/pages', [EVPageController::class, 'index'])->name('pages.index');
        Route::get('/pages/create', [EVPageController::class, 'create'])->name('page.create');
        Route::get('/pages/edit/{id}', [EVPageController::class, 'edit'])->name('page.edit');

        /* Blog Posts */
        Route::get('/blog/posts', [EVBlogPostController::class, 'index'])->name('blog.posts.index');
        Route::get('/blog/posts/create', [EVBlogPostController::class, 'create'])->name('blog.post.create');
        Route::get('/blog/posts/edit/{id}', [EVBlogPostController::class, 'edit'])->name('blog.post.edit');

        /* Plans */
        Route::get('/plans', [EVPlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/create', [EVPlanController::class, 'create'])->name('plan.create');
        Route::get('/plans/edit/{id}', [EVPlanController::class, 'edit'])->name('plan.edit');

        /* Attributes */
        Route::get('/attributes/type/{content_type}', [EVAttributesController::class, 'index'])->name('attributes.index');
        Route::get('/attributes/type/{content_type}/create', [EVAttributesController::class, 'create'])->name('attributes.create');
        Route::get('/attributes/edit/{id}', [EVAttributesController::class, 'edit'])->name('attributes.edit');

        /* Orders */
        Route::get('/orders', [EVOrderController::class, 'index'])->name('orders.index');
        Route::get('/order/create', [EVOrderController::class, 'create'])->name('order.create');
        Route::get('/order/view/{id}', [EVOrderController::class, 'details'])->name('order.details');
        //        Route::resource('orders', 'EVOrderController')->parameters([
        //            'orders' => 'id',
        //        ])->except(['destroy']);
        Route::get('/orders/destroy/{id}', [App\Http\Controllers\OrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/orders/details', [App\Http\Controllers\OrderController::class, 'order_details'])->name('orders.details');
        Route::post('/orders/update_delivery_status', [App\Http\Controllers\OrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');
        Route::post('/orders/update_payment_status', [App\Http\Controllers\OrderController::class, 'update_payment_status'])->name('orders.update_payment_status');

        /* My Purchases/Wishlist/Viewed Items */
        Route::get('/purchases/all', [EVOrderController::class, 'my_purchases'])->name('my.purchases.all');

        /* My account */
        Route::get('/account-settings', [EVAccountController::class, 'account_settings'])->name('my.account.settings');
        Route::get('/account-settings/shops', [EVAccountController::class, 'account_shops_settings'])->name('my.account.shops');
        Route::get('/profile/{id}', [EVAccountController::class, 'user_profile'])->name('user.profile');

        /* Settings pages*/
        Route::post('/ev-design-settings', [EVAccountController::class, 'design_settings_store'])->name('settings.design.store');
        Route::get('/ev-payment-methods-settings', [EVAccountController::class, 'payment_methods_settings'])->name('settings.payment_methods');
        Route::get('/domain-settings', [EVAccountController::class, 'domain_settings'])->name('settings.domains');
        Route::get('/staff-settings', [EVAccountController::class, 'staff_settings'])->name('settings.staff_settings');
        Route::get('/shop-settings', [EVAccountController::class, 'shop_settings'])->name('settings.shop_settings');
        Route::get('/app-settings', [EVAccountController::class, 'app_settings'])->name('settings.app_settings');
        Route::get('/plans-management', [EVPlanController::class, 'my_plans_management'])->name('my.plans.management');

        // Payment Methods callback routes
        Route::get('/checkout/paysera/accepted/{invoice_id}', [PayseraGateway::class, 'accepted'])->name('gateway.paysera.accepted');
        Route::get('/checkout/paysera/canceled/{invoice_id}', [PayseraGateway::class, 'canceled'])->name('gateway.paysera.canceled');
        Route::get('/checkout/paysera/callback/{invoice_id}', [PayseraGateway::class, 'callback'])->name('gateway.paysera.callback');
        Route::post('/checkout/execute/payment/{invoice_id}', [EVCheckoutController::class, 'executePayment'])->name('checkout.execute.payment');

        // WeMediaLibrary
        Route::post('/froala/upload-image', [WeMediaController::class, 'froalaImageUpload'])->name('we-media-library.froala.upload-image');
        Route::get('/froala/load-images', [WeMediaController::class, 'froalaLoadImages'])->name('we-media-library.froala.load-images');

        // ---------------------------------------------------- //

        Route::get('/reviews', [App\Http\Controllers\ReviewController::class, 'index'])->name('reviews.index');
        /* TODO: Create new route for adding reviews for products, now this route is reviews for companies */
        Route::get('/shop/{company_name}/review/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
        Route::post('/review/store', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        Route::post('/review/published', [App\Http\Controllers\ReviewController::class, 'updatePublished'])->name('reviews.published');

        Route::resource('/withdraw_requests', 'SellerWithdrawRequestController');
        Route::get('/withdraw_requests_all', [App\Http\Controllers\SellerWithdrawRequestController::class, 'request_index'])->name('withdraw_requests_all');
        Route::post('/withdraw_request/payment_modal', [App\Http\Controllers\SellerWithdrawRequestController::class, 'payment_modal'])->name('withdraw_request.payment_modal');
        Route::post('/withdraw_request/message_modal', [App\Http\Controllers\SellerWithdrawRequestController::class, 'message_modal'])->name('withdraw_request.message_modal');

        //Product Bulk Upload
        Route::get('/product-bulk-upload/index', [App\Http\Controllers\ProductBulkUploadController::class, 'index'])->name('product_bulk_upload.index');
        Route::post('/bulk-product-upload', [App\Http\Controllers\ProductBulkUploadController::class, 'bulk_upload'])->name('bulk_product_upload');
        Route::get('/product-csv-download/{type}', [App\Http\Controllers\ProductBulkUploadController::class, 'import_product'])->name('product_csv.download');
        Route::get('/vendor-product-csv-download/{id}', [App\Http\Controllers\ProductBulkUploadController::class, 'import_vendor_product'])->name('import_vendor_product.download');
        Route::prefix('bulk-upload/download')->group(function () {
            Route::get('/category', [App\Http\Controllers\ProductBulkUploadController::class, 'pdf_download_category'])->name('pdf.download_category');
            Route::get('/brand', [App\Http\Controllers\ProductBulkUploadController::class, 'pdf_download_brand'])->name('pdf.download_brand');
            Route::get('/seller', [App\Http\Controllers\ProductBulkUploadController::class, 'pdf_download_seller'])->name('pdf.download_seller');
        });

        //Product Export
        Route::get('/product-bulk-export', [App\Http\Controllers\ProductBulkUploadController::class, 'export'])->name('product_bulk_export.index');

        Route::resource('digitalproducts', 'DigitalProductController')->parameters([
            'digitalproducts' => 'id',
        ])->except(['destroy']);
        //    Route::get('/digitalproducts/edit/{id}', [App\Http\Controllers\DigitalProductController::class, 'edit'])->name('digitalproduct.edit');
        Route::get('/digitalproducts/destroy/{id}', [App\Http\Controllers\DigitalProductController::class, 'destroy'])->name('digitalproducts.destroy');
        Route::get('/digitalproducts/download/{id}', [App\Http\Controllers\DigitalProductController::class, 'download'])->name('digitalproducts.download');

        //Reports
        Route::get('/commission-log', [App\Http\Controllers\ReportController::class, 'commission_history'])->name('commission-log.index');

        //Document and Gallery
        Route::resource('documentgallery', 'DocumentGalleryController')->parameters([
            'documentgallery' => 'id',
        ])->except(['destroy']);
        //    Route::get('/documentgallery/edit/{id}', [App\Http\Controllers\DocumentGalleryController::class, 'edit'])->name('documentgallery.edit');
        //    Route::post('/documentgallery/update/{id}', [App\Http\Controllers\DocumentGalleryController::class, 'update'])->name('documentgallery.update');
        Route::get('/documentgallery/destroy/{id}', [App\Http\Controllers\DocumentGalleryController::class, 'destroy'])->name('documentgallery.destroy');

        //Notifications
        Route::resource('notifications', 'NotificationController');
        Route::post('/notifications/mark-all-as-read', [App\Http\Controllers\NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_as_read');

        /* Document (eSignatures and SmartID)  Roiutes */
        Route::get('/documents', [App\Http\Controllers\DocumentsController::class, 'index'])->name('documents.index');
    });

    // Integrations
    Route::get('/integrations', [App\Http\Controllers\Integrations\IntegrationsController::class, 'index'])->name('integrations.index');

    Route::get('/integrations/facebook-business-export', [App\Http\Controllers\Integrations\FacebookBusinessController::class, 'export'])->name('integrations.facebook-business.export');
    Route::get('/integrations/woocommerce', [App\Http\Controllers\Integrations\WooCommerceController::class, 'index'])->name('integrations.woocommerce');
    Route::get('/integrations/woocommerce/import/{type}', [App\Http\Controllers\Integrations\WooCommerceController::class, 'import'])->name('integrations.woocommerce.import');
    Route::get('/integrations/woocommerce/import-results/{type}', [App\Http\Controllers\Integrations\WooCommerceController::class, 'import_results'])->name('integrations.woocommerce.import-results');

    /* FEED Routes */
    /* TODO: Add this to separate feed.php routes file */
    Route::get('/feed', [App\Http\Controllers\FeedController::class, 'index'])->name('feed.index')->middleware('auth');
    Route::get('/feed/shops', [App\Http\Controllers\FeedController::class, 'shops'])->name('feed.shops');
    Route::get('/feed/products', [App\Http\Controllers\FeedController::class, 'products'])->name('feed.products');
    /* This is general route to catch all requests to /* */
    // Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show_custom_page'])->name('custom-pages.index');
});

<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\App;
use App\Http\Controllers\DocumentGalleryController;
use App\Http\Controllers\EVAccountController;
use App\Http\Controllers\EVAttributesController;
use App\Http\Controllers\EVBlogPostController;
use App\Http\Controllers\EVCategoryController;
use App\Http\Controllers\EVCheckoutController;
use App\Http\Controllers\EVOrderController;
use App\Http\Controllers\EVPageController;
use App\Http\Controllers\EVPlanController;
use App\Http\Controllers\EVProductController;
use App\Http\Controllers\FeedController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EVDownloadsController;
use App\Http\Controllers\CRMController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\WeSubscriptionsController;
use App\Http\Controllers\Integrations\FacebookBusinessController;
use App\Http\Controllers\Integrations\IntegrationsController;
use App\Http\Controllers\Integrations\WooCommerceController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\WeMediaController;
use App\Http\Controllers\WeQuizController;
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
        Route::get('/show/{previewID}', [\App\Http\Controllers\EVPreviewController::class, 'show'])->name('show');
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
        Route::get('leads/success', [LeadController::class, 'success'])->name('leads.success');
        Route::resource('leads', LeadController::class);


        /* TODO: Admin and seller only */

        // ---------------------------------------------------- //

        /* Products */
        Route::get('/products', [EVProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [EVProductController::class, 'create2'])->name('product.create');
        // Route::get('/ev-products/create', [EVProductController::class, 'create'])->name('product.create');
        Route::get('/products/edit/{id}', [EVProductController::class, 'edit'])->name('product.edit');
        Route::get('/products/edit/{id}/details', [EVProductController::class, 'product_details'])->name('product.details');
        Route::get('/products/edit/{id}/details/activity', [EVProductController::class, 'product_activity'])->name('product.activity');
        Route::get('/products/edit/{id}/variations', [EVProductController::class, 'edit_variations'])->name('product.edit.variations');
        Route::get('/products/edit/{id}/stock-management', [EVProductController::class, 'edit_stocks'])->name('product.edit.stocks');
        Route::get('/products/edit/{id}/course-management', [EVProductController::class, 'edit_course'])->name('product.edit.course');
        Route::get('/products/preview/{id}/thank-you', [EVProductController::class, 'thank_you_preview'])->name('product.thank_you_preview');

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
        Route::get('/order/details/{id}', [EVOrderController::class, 'details'])->name('order.details');
        //        Route::resource('orders', 'EVOrderController')->parameters([
        //            'orders' => 'id',
        //        ])->except(['destroy']);
        Route::get('/orders/destroy/{id}', [EVOrderController::class, 'destroy'])->name('orders.destroy');
        Route::post('/orders/details', [EVOrderController::class, 'order_details'])->name('orders.details');
        Route::post('/orders/update_delivery_status', [EVOrderController::class, 'update_delivery_status'])->name('orders.update_delivery_status');
        Route::post('/orders/update_payment_status', [EVOrderController::class, 'update_payment_status'])->name('orders.update_payment_status');

        /* My Purchases/Wishlist/Viewed Items */
        Route::get('/my/purchases/all', [EVOrderController::class, 'my_purchases'])->name('my.purchases.index');
        Route::get('/my/wishlist/all', [EVOrderController::class, 'my_purchases'])->name('my.wishlist.index');
        Route::get('/my/orders/all', [EVOrderController::class, 'my_orders'])->name('my.orders.all');

        /* My Downloads (all) */
        Route::get('/downloads/all', [EVDownloadsController::class, 'my_downloads'])->name('my.downloads.all');


        /* My account */
        Route::get('/account-settings', [EVAccountController::class, 'account_settings'])->name('my.account.settings');
        Route::get('/account-settings/shops', [EVAccountController::class, 'account_shops_settings'])->name('my.account.shops');
        Route::get('/profile/{id}', [EVAccountController::class, 'user_profile'])->name('user.profile');
        Route::get('/user/{id}/details', [EVAccountController::class, 'user_details'])->name('user.details');

        /* CRM */
        Route::get('/crm/customers', [CRMController::class, 'customers_index'])->name('crm.all_customers')->middleware('admin'); // TODO: THink about handling permissions a bit differently

        /* Settings pages*/
        Route::post('/ev-design-settings', [EVAccountController::class, 'design_settings_store'])->name('settings.design.store');
        Route::get('/ev-payment-methods-settings', [EVAccountController::class, 'payment_methods_settings'])->name('settings.payment_methods');
        Route::get('/domain-settings', [EVAccountController::class, 'domain_settings'])->name('settings.domains');
        Route::get('/staff-settings', [EVAccountController::class, 'staff_settings'])->name('settings.staff_settings');
        Route::get('/shop-settings', [EVAccountController::class, 'shop_settings'])->name('settings.shop_settings');
        Route::get('/app-settings', [EVAccountController::class, 'app_settings'])->name('settings.app_settings');
        Route::get('/app-settings/{settings_group}', [EVAccountController::class, 'app_settings'])->name('settings.app.group');

        Route::get('/plans-management', [EVPlanController::class, 'my_plans_management'])->name('my.plans.management');
        Route::get('/plans-management/add-seats', [EVPlanController::class, 'add_seats'])->name('subscriptions.create');

        // Payment Methods callback routes
        Route::get('/checkout/paysera/accepted/{invoice_id}', [PayseraGateway::class, 'accepted'])->name('gateway.paysera.accepted');
        Route::get('/checkout/paysera/canceled/{invoice_id}', [PayseraGateway::class, 'canceled'])->name('gateway.paysera.canceled');
        Route::get('/checkout/paysera/callback/{invoice_id}', [PayseraGateway::class, 'callback'])->name('gateway.paysera.callback');
        Route::post('/checkout/execute/payment/{invoice_id}', [EVCheckoutController::class, 'executePayment'])->name('checkout.execute.payment');

        // WeMediaLibrary
        Route::post('/froala/upload-image', [WeMediaController::class, 'froalaImageUpload'])->name('we-media-library.froala.upload-image');
        Route::get('/froala/load-images', [WeMediaController::class, 'froalaLoadImages'])->name('we-media-library.froala.load-images');

        // WeQuizz
        Route::get('/quiz/index', [WeQuizController::class, 'index'])->name('dashboard.we-quiz.index');
        Route::get('/quiz/create', [WeQuizController::class, 'create'])->name('dashboard.we-quiz.create');
        Route::get('/quiz/details/{id}', [WeQuizController::class, 'details'])->name('dashboard.we-quiz.details');
        Route::get('/quiz/{id}/results', [WeQuizController::class, 'results'])->name('dashboard.we-quiz.results');
        Route::get('/quiz/result/{id}', [WeQuizController::class, 'quiz_result_details'])->name('dashboard.we-quiz.result.details');
        Route::get('/quiz/edit/{id}', [WeQuizController::class, 'edit'])->name('dashboard.we-quiz.edit');
        Route::get('/quiz/show/{id}', [WeQuizController::class, 'show'])->name('dashboard.we-quiz.show');
        // ---------------------------------------------------- //

        // Route::get('/reviews', [ReviewController::class, 'index'])->name('reviews.index');
        // /* TODO: Create new route for adding reviews for products, now this route is reviews for companies */
        // Route::get('/shop/{company_name}/review/create', [App\Http\Controllers\ReviewController::class, 'create'])->name('reviews.create');
        // Route::post('/review/store', [App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
        // Route::post('/review/published', [App\Http\Controllers\ReviewController::class, 'updatePublished'])->name('reviews.published');




        //Product Export
        // Route::get('/product-bulk-export', [App\Http\Controllers\ProductBulkUploadController::class, 'export'])->name('product_bulk_export.index');


        //Reports
        // Route::get('/commission-log', [App\Http\Controllers\ReportController::class, 'commission_history'])->name('commission-log.index');

        //Document and Gallery
        Route::resource('documentgallery', DocumentGalleryController::class)->parameters([
            'documentgallery' => 'id',
        ])->except(['destroy']);
        //    Route::get('/documentgallery/edit/{id}', [App\Http\Controllers\DocumentGalleryController::class, 'edit'])->name('documentgallery.edit');
        //    Route::post('/documentgallery/update/{id}', [App\Http\Controllers\DocumentGalleryController::class, 'update'])->name('documentgallery.update');
        Route::get('/documentgallery/destroy/{id}', [DocumentGalleryController::class, 'destroy'])->name('documentgallery.destroy');

        //Notifications
        Route::resource('notifications', NotificationController::class);
        Route::post('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark_all_as_read');

        /* Document (eSignatures and SmartID)  Roiutes */
        Route::get('/documents', [DocumentsController::class, 'index'])->name('documents.index');
    });

    // Integrations
    Route::get('/integrations', [IntegrationsController::class, 'index'])->name('integrations.index');
    Route::get('/integrations/facebook-business-export', [FacebookBusinessController::class, 'export'])->name('integrations.facebook-business.export');
    Route::get('/integrations/woocommerce', [WooCommerceController::class, 'index'])->name('integrations.woocommerce');
    Route::get('/integrations/woocommerce/import/{type}', [WooCommerceController::class, 'import'])->name('integrations.woocommerce.import');
    Route::get('/integrations/woocommerce/import-results/{type}', [WooCommerceController::class, 'import_results'])->name('integrations.woocommerce.import-results');
    Route::get('/integrations/woocommerce/transfer/import', [WooCommerceController::class, 'transfer_woocommerce_produts'])->name('integrations.woocommerce.transfer-1');
    Route::get('/integrations/woocommerce/transfer/export', [WooCommerceController::class, 'transfer_woocommerce_produts_to_destination'])->name('integrations.woocommerce.transfer-2');

    /* FEED Routes */
    /* TODO: Add this to separate feed.php routes file */
    Route::get('/feed', [FeedController::class, 'index'])->name('feed.index')->middleware('auth');
    Route::get('/feed/trending', [FeedController::class, 'trending'])->name('feed.trending')->middleware('auth');
    // Route::get('/feed/trending', [FeedController::class, 'trending'])->name('feed.trending')->middleware('auth');
    Route::get('/feed/discussions', [FeedController::class, 'discussions'])->name('feed.discussions')->middleware('auth');
    Route::get('/feed/tags', [FeedController::class, 'tags'])->name('feed.tags');
    Route::get('/feed/bookmarks', [FeedController::class, 'bookmarks'])->name('feed.bookmarks');
    Route::get('/feed/shops', [FeedController::class, 'shops'])->name('feed.shops');
    Route::get('/feed/products', [FeedController::class, 'products'])->name('feed.products');
    Route::get('/feed/courses', [FeedController::class, 'courses'])->name('feed.courses');

    /* This is general route to catch all requests to /* */
    // Route::get('/{slug}', [App\Http\Controllers\PageController::class, 'show_custom_page'])->name('custom-pages.index');

    /* IMPORTANT: Last set of routes! To define missing pages and routes */
    /* Catch All Routes: If nothing is matched, try to find a page or throw 404 */
    Route::get('/{data1}', [PageController::class, 'show_custom_page']);
    Route::get('/{data1}/{data2}', [PageController::class, 'show_custom_page']);

    Route::fallback(function () {
        abort(404);
    });
});


Route::middleware([
    'web',
    'auth',
    InitializeTenancyByDomainAndVendorDomains::class,
    PreventAccessFromCentralDomains::class,
    SetDashboard::class,
    VendorMode::class,
])->prefix('api')->name('api.dashboard.')->group(function () {
    Route::post('/quiz/save', [WeQuizController::class, 'save_quiz'])->name('we-quiz.create');
    Route::post('/quiz/save/{id}', [WeQuizController::class, 'save_quiz'])->name('we-quiz.update');
    Route::post('/quiz/result/{id}/passed-toggle', [WeQuizController::class, 'toggle_passed'])->name('we-quiz.toggle-passed');

    Route::get('/subscription/{subscription_id}/change-free-trial-plan/{new_plan_id}', [WeSubscriptionsController::class, 'change_free_trial_plan'])->name('subscription.change-free-trial-plan');
    Route::get('/subscription/{subscription_id}/upcoming-invoice/plan/{new_plan_id}/{interval}', [WeSubscriptionsController::class, 'generate_upcoming_invoice_from_stripe'])->name('subscription.upcoming.invoice.stripe');
    Route::post('/subscription/calculate-potential-invoice', [WeSubscriptionsController::class, 'calculate_potential_invoice'])->name('subscription.calculate-potential-invoice.stripe');

});

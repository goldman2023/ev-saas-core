<?php
/*
 * API Verision 2 (API v2)
 */
Route::prefix('v2')->as('api.')->group(function () {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::post('login', 'Api\V2\AuthController@login')->name('login');
        Route::post('signup', 'Api\V2\AuthController@signup')->name('signup');
        Route::post('social-login', 'Api\V2\AuthController@socialLogin')->name('social-login');
        Route::post('password/forget_request', 'Api\V2\PasswordResetController@forgetRequest')->name('password.forget-request');
        Route::post('password/confirm_reset', 'Api\V2\PasswordResetController@confirmReset')->name('password.confirm-reset');
        Route::post('password/resend_code', 'Api\V2\PasswordResetController@resendCode')->name('password.resend-code');
        Route::middleware('auth:api')->group(function () {
            Route::get('logout', 'Api\V2\AuthController@logout')->name('logout');
            Route::get('user', 'Api\V2\AuthController@user')->name('user');
        });
        Route::post('resend_code', 'Api\V2\AuthController@resendCode')->name('resend-code');
        Route::post('confirm_code', 'Api\V2\AuthController@confirmCode')->name('confirm-code');
    });

    Route::apiResource('banners', 'Api\V2\BannerController')->only('index');

    Route::get('brands/top', 'Api\V2\BrandController@top');
    Route::apiResource('brands', 'Api\V2\BrandController')->only('index');

    Route::apiResource('business-settings', 'Api\V2\BusinessSettingController')->only('index');

    Route::get('categories/featured', 'Api\V2\CategoryController@featured');
    Route::get('categories/home', 'Api\V2\CategoryController@home');
    Route::get('categories/top', 'Api\V2\CategoryController@top');
    Route::apiResource('categories', 'Api\V2\CategoryController')->only('index');
    Route::get('sub-categories/{id}', 'Api\V2\SubCategoryController@index')->name('subCategories.index');

    Route::apiResource('colors', 'Api\V2\ColorController')->only('index');

    Route::apiResource('currencies', 'Api\V2\CurrencyController')->only('index');

    Route::apiResource('customers', 'Api\V2\CustomerController')->only('show');

    Route::apiResource('general-settings', 'Api\V2\GeneralSettingController')->only('index');

    Route::apiResource('home-categories', 'Api\V2\HomeCategoryController')->only('index');

    //Route::get('purchase-history/{id}', 'Api\V2\PurchaseHistoryController@index')->middleware('auth:api');
    //Route::get('purchase-history-details/{id}', 'Api\V2\PurchaseHistoryDetailController@index')->name('purchaseHistory.details')->middleware('auth:api');

    Route::get('purchase-history/{id}', 'Api\V2\PurchaseHistoryController@index');
    Route::get('purchase-history-details/{id}', 'Api\V2\PurchaseHistoryController@details');
    Route::get('purchase-history-items/{id}', 'Api\V2\PurchaseHistoryController@items');

    Route::get('filter/categories', 'Api\V2\FilterController@categories');
    Route::get('filter/brands', 'Api\V2\FilterController@brands');

    Route::get('products/admin', 'Api\V2\ProductController@admin');
    Route::get('products/seller/{id}', 'Api\V2\ProductController@seller');
    Route::get('products/category/{id}', 'Api\V2\ProductController@category')->name('products.category');
    Route::get('products/sub-category/{id}', 'Api\V2\ProductController@subCategory')->name('products.subCategory');
    Route::get('products/sub-sub-category/{id}', 'Api\V2\ProductController@subSubCategory')->name('products.subSubCategory');
    Route::get('products/brand/{id}', 'Api\V2\ProductController@brand')->name('products.brand');
    Route::get('products/todays-deal', 'Api\V2\ProductController@todaysDeal');
    Route::get('products/featured', 'Api\V2\ProductController@featured');
    Route::get('products/best-seller', 'Api\V2\ProductController@bestSeller');
    Route::get('products/related/{id}', 'Api\V2\ProductController@related')->name('products.related');

    Route::get('products/featured-from-seller/{id}', 'Api\V2\ProductController@newFromSeller')->name('products.featuredFromSeller');
    Route::get('products/search', 'Api\V2\ProductController@search');
    Route::get('products/variant/price', 'Api\V2\ProductController@variantPrice');
    Route::get('products/home', 'Api\V2\ProductController@home');
    Route::apiResource('products', 'Api\V2\ProductController')->except(['store', 'update', 'destroy']);

    Route::get('cart-summary/{user_id}/{owner_id}', 'Api\V2\CartController@summary')->middleware('auth:api');
    Route::post('carts/process', 'Api\V2\CartController@process')->middleware('auth:api');
    Route::post('carts/add', 'Api\V2\CartController@add')->middleware('auth:api');
    Route::post('carts/change-quantity', 'Api\V2\CartController@changeQuantity')->middleware('auth:api');
    Route::apiResource('carts', 'Api\V2\CartController')->only('destroy')->middleware('auth:api');
    Route::post('carts/{user_id}', 'Api\V2\CartController@getList')->middleware('auth:api');


    Route::post('coupon-apply', 'Api\V2\CheckoutController@apply_coupon_code')->middleware('auth:api');
    Route::post('coupon-remove', 'Api\V2\CheckoutController@remove_coupon_code')->middleware('auth:api');

    Route::post('update-address-in-cart', 'Api\V2\AddressController@updateAddressInCart')->middleware('auth:api');

    Route::get('payment-types', 'Api\V2\PaymentTypesController@getList');

    Route::get('reviews/product/{id}', 'Api\V2\ReviewController@index')->name('reviews.index');

    Route::get('shop/user/{id}', 'Api\V2\ShopController@shopOfUser')->middleware('auth:api');
    Route::get('shops/details/{id}', 'Api\V2\ShopController@info')->name('shops.info');
    Route::get('shops/products/all/{id}', 'Api\V2\ShopController@allProducts')->name('shops.allProducts');
    Route::get('shops/products/top/{id}', 'Api\V2\ShopController@topSellingProducts')->name('shops.topSellingProducts');
    Route::get('shops/products/featured/{id}', 'Api\V2\ShopController@featuredProducts')->name('shops.featuredProducts');
    Route::get('shops/products/new/{id}', 'Api\V2\ShopController@newProducts')->name('shops.newProducts');
    Route::get('shops/brands/{id}', 'Api\V2\ShopController@brands')->name('shops.brands');
    Route::apiResource('shops', 'Api\V2\ShopController')->only('index');

    Route::apiResource('sliders', 'Api\V2\SliderController')->only('index');

//    Route::get('wishlists/{id}', 'Api\V2\WishlistController@index')->middleware('auth:api');
//    Route::get('wishlists-check-product', 'Api\V2\WishlistController@isProductInWishlist')->middleware('auth:api');
//    Route::apiResource('wishlists', 'Api\V2\WishlistController')->except(['index', 'update', 'show'])->middleware('auth:api');

    Route::get('wishlists-check-product', 'Api\V2\WishlistController@isProductInWishlist');
    Route::get('wishlists-add-product', 'Api\V2\WishlistController@add');
    Route::get('wishlists-remove-product', 'Api\V2\WishlistController@remove');
    Route::get('wishlists/{id}', 'Api\V2\WishlistController@index');
    Route::apiResource('wishlists', 'Api\V2\WishlistController')->except(['index', 'update', 'show']);

    Route::apiResource('settings', 'Api\V2\SettingsController')->only('index');

    Route::get('policies/seller', 'Api\V2\PolicyController@sellerPolicy')->name('policies.seller');
    Route::get('policies/support', 'Api\V2\PolicyController@supportPolicy')->name('policies.support');
    Route::get('policies/return', 'Api\V2\PolicyController@returnPolicy')->name('policies.return');

    Route::get('user/info/{id}', 'Api\V2\UserController@info')->middleware('auth:api');
    Route::post('user/info/update', 'Api\V2\UserController@updateName')->middleware('auth:api');
    Route::get('user/shipping/address/{id}', 'Api\V2\AddressController@addresses')->middleware('auth:api');
    Route::post('user/shipping/create', 'Api\V2\AddressController@createShippingAddress')->middleware('auth:api');
    Route::get('user/shipping/delete/{id}', 'Api\V2\AddressController@deleteShippingAddress')->middleware('auth:api');

    Route::post('get-user-by-access_token', 'Api\V2\UserController@getUserInfoByAccessToken');

    Route::get('cities', 'Api\V2\AddressController@getCities');
    Route::get('countries', 'Api\V2\AddressController@getCountries');

    Route::post('shipping_cost', 'Api\V2\ShippingController@shipping_cost')->middleware('auth:api');

    Route::post('coupon/apply', 'Api\V2\CouponController@apply')->middleware('auth:api');


    Route::any('stripe', 'Api\V2\StripeController@stripe');
    Route::any('/stripe/create-checkout-session', 'Api\V2\StripeController@create_checkout_session')->name('stripe.get_token');
    Route::any('/stripe/payment/callback', 'Api\V2\StripeController@callback')->name('stripe.callback');
    Route::any('/stripe/success', 'Api\V2\StripeController@success')->name('stripe.success');
    Route::any('/stripe/cancel', 'Api\V2\StripeController@cancel')->name('stripe.cancel');

    Route::any('paypal/payment/url', 'Api\V2\PaypalController@getUrl')->name('paypal.url');
    Route::any('paypal/payment/done', 'Api\V2\PaypalController@getDone')->name('paypal.done');
    Route::any('paypal/payment/cancel', 'Api\V2\PaypalController@getCancel')->name('paypal.cancel');

    Route::post('payments/pay/wallet', 'Api\V2\WalletController@processPayment')->middleware('auth:api');
    Route::post('payments/pay/cod', 'Api\V2\PaymentController@cashOnDelivery')->middleware('auth:api');

    Route::post('order/store', 'Api\V2\OrderController@store')->middleware('auth:api');

    Route::get('profile/counters/{user_id}', 'Api\V2\ProfileController@counters')->middleware('auth:api');

    Route::get('wallet/balance/{id}', 'Api\V2\WalletController@balance')->middleware('auth:api');
    Route::get('wallet/history/{id}', 'Api\V2\WalletController@walletRechargeHistory')->middleware('auth:api');

    Route::get('flash-deals', 'Api\V2\FlashDealController@index');
    Route::get('flash-deal-products/{id}', 'Api\V2\FlashDealController@products');
});

Route::fallback(function() {
    return response()->json([
        'data' => [],
        'success' => false,
        'status' => 404,
        'message' => 'Invalid Route'
    ]);
});

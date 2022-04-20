<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::dropIfExists('app_settings');
        Schema::dropIfExists('addons');
        Schema::dropIfExists('banners');
        Schema::dropIfExists('blog_categories');
        Schema::dropIfExists('brand_translations');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('city_translations');
        Schema::dropIfExists('colors');
        Schema::dropIfExists('commission_histories');
        Schema::dropIfExists('conversations');
        Schema::dropIfExists('coupon_usages');
        Schema::dropIfExists('coupons');
        Schema::dropIfExists('customer_package_payments');
        Schema::dropIfExists('customer_package_translations');
        Schema::dropIfExists('customer_packages');
        Schema::dropIfExists('customer_product_translations');
        Schema::dropIfExists('customer_products');
        Schema::dropIfExists('general_settings');
        Schema::dropIfExists('home_categories');
        Schema::dropIfExists('links');
        Schema::dropIfExists('messages');
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('page_translations');
        Schema::dropIfExists('payments');
        Schema::dropIfExists('pickup_point_translations');
        Schema::dropIfExists('pickup_points');
        Schema::dropIfExists('policies');
        Schema::dropIfExists('role_translations');
        Schema::dropIfExists('seller_withdraw_requests');
        Schema::dropIfExists('sellers');
        Schema::dropIfExists('seo_settings');
        Schema::dropIfExists('sliders');
        Schema::dropIfExists('subscribers');
        Schema::dropIfExists('ticket_replies');
        Schema::dropIfExists('tickets');
        Schema::dropIfExists('company_category');
        Schema::dropIfExists('affiliate_banners');
        Schema::dropIfExists('events');
        Schema::dropIfExists('event_translations');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('seller_package_payments');
        Schema::dropIfExists('seller_package_translations');
        Schema::dropIfExists('seller_packages');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

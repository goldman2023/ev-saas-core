<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('order_details');
        Schema::dropIfExists('orders');

        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('shop_id');
            $table->unsignedInteger('user_id')->nullable();

            // Order data columns
            $table->string('email', 255)->index();
            $table->string('billing_first_name', 255);
            $table->string('billing_last_name', 255);
            $table->string('billing_company', 255)->nullable();
            $table->string('billing_address', 255);
            $table->string('billing_country', 255);
            $table->string('billing_state', 255);
            $table->string('billing_city', 255);
            $table->string('billing_zip', 255);
            $table->json('phone_numbers');
            $table->boolean('same_billing_shipping')->default(1);
            $table->string('shipping_first_name', 255)->nullable();
            $table->string('shipping_last_name', 255)->nullable();
            $table->string('shipping_company', 255)->nullable();
            $table->string('shipping_address', 255)->nullable();
            $table->string('shipping_country', 255)->nullable();
            $table->string('shipping_state', 255)->nullable();
            $table->string('shipping_city', 255)->nullable();
            $table->string('shipping_zip', 255)->nullable();
            $table->string('note', 1000)->nullable();

            // Order numbers columns
            $table->float('base_price');
            $table->float('discount_amount');
            $table->float('subtotal_price');
            $table->float('total_price');

            $table->float('shipping_method'); // TODO: This will be adjusted when Shipping logic in BE is created
            $table->float('shipping_cost')->default(0);
            $table->float('tax')->default(0);

            // Order specific columns
            $table->string('payment_method', 50);
            $table->string('payment_status', 25)->default('unpaid');
            $table->string('shipping_status', 25)->default('pending');
            $table->boolean('viewed')->default(0);

            $table->timestamps();
            $table->softDeletes('deleted_at');

            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade'); // When shop is removed, it's orders are removed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null'); // When user is removed, Set relation to NULL (We DON'T want to remove orders when user is removed!)
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('order_id');
            $table->string('subject_type')->nullable(); // THESE CAN BE NULL (It may happen that item is removed from DB, but we still do not want to remove any Order items of that item)
            $table->unsignedBigInteger('subject_id')->nullable(); // THESE CAN BE NULL

            // Order items columns (data to know more about the subject, if it's removed...)
            $table->string('title', 255); // This is needed when subject is removed from DB
            $table->string('excerpt', 255); // This is potentially needed when subject is removed from DB
            $table->json('variant')->nullable(); // This is a key:value object of attribute:attribute_value -> it's used for easier variant recognition

            // Stocks
            $table->float('quantity'); // quantity of the item bought
            $table->json('serial_numbers'); // serial_numbers bought (if any) - NO DB RELATION! Because serial numbers may be deleted for some reason (even though they use softDeletes)

            // Order items numbers columns
            $table->float('base_price');
            $table->float('discount_amount');
            $table->float('subtotal_price');
            $table->float('total_price');

            $table->float('tax')->default(0);

            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade'); // When order is removed, its items are removed too!
            $table->index(['subject_type', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
}

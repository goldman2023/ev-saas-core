<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('order_id');
            $table->integer('seller_id')->nullable();
            $table->integer('product_id');
            $table->longText('variation')->nullable();
            $table->double('price', 20, 2)->nullable();
            $table->double('tax', 20, 2)->default(0.00);
            $table->double('shipping_cost', 20, 2)->default(0.00);
            $table->integer('quantity')->nullable();
            $table->string('payment_status', 10)->default('unpaid');
            $table->string('delivery_status', 20)->nullable()->default('pending');
            $table->string('shipping_type', 255)->nullable();
            $table->integer('pickup_point_id')->nullable();
            $table->string('product_referral_code', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_details');
    }
}

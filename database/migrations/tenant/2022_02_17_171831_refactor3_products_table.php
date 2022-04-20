<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug', 255)->after('name')->change();
            $table->dropColumn('added_by');
            $table->float('unit_price')->default(0)->nullable()->change();
            $table->dropColumn('todays_deal');
            $table->dropColumn('published');
            $table->string('status', 50)->default('draft')->after('brand_id')->index();

            $table->dropColumn('cash_on_delivery');
            $table->dropColumn('featured');
            $table->dropColumn('seller_featured');

            $table->dropColumn('shipping_type');
            $table->dropColumn('shipping_cost');
            $table->dropColumn('is_quantity_multiplied');
            $table->dropColumn('est_shipping_days');
            $table->dropColumn('barcode');
            $table->dropColumn('num_of_sale');

            $table->string('excerpt', 320)->after('description')->change();

            $table->integer('num_of_sales')->default(0);
        });

        Schema::table('product_stocks', function (Blueprint $table) {
            $table->string('barcode', 255)->after('sku')->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
        });
    }
};

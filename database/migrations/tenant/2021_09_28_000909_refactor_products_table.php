<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('attributes');
            $table->dropColumn('choice_options');
            $table->dropColumn('colors');
            $table->dropColumn('variations');
            $table->dropColumn('current_stock'); // DONE: Create current_stock property in Product model
            $table->dropColumn('low_stock_quantity'); // DONE: Create low_stock_qty property in Product model and move it to ProductStocks table
            $table->dropColumn('category_id');
            $table->dropColumn('subcategory_id');
            $table->dropColumn('subsubcategory_id');

            $table->float('purchase_price')->nullable()->change();
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
}

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
            if (Schema::hasColumn('products', 'attributes')) {
                $table->dropColumn('attributes');
            }
            if (Schema::hasColumn('products', 'choice_options')) {
                $table->dropColumn('choice_options');
            }
            if (Schema::hasColumn('products', 'colors')) {
                $table->dropColumn('colors');
            }
            if (Schema::hasColumn('products', 'variations')) {
                $table->dropColumn('variations');
            }
            if (Schema::hasColumn('products', 'current_stock')) {
                $table->dropColumn('current_stock');
            }
            if (Schema::hasColumn('products', 'low_stock_quantity')) {
                $table->dropColumn('low_stock_quantity');
            }
            if (Schema::hasColumn('products', 'category_id')) {
                $table->dropColumn('category_id');
            }
            if (Schema::hasColumn('products', 'subcategory_id')) {
                $table->dropColumn('subcategory_id');
            }
            if (Schema::hasColumn('products', 'subsubcategory_id')) {
                $table->dropColumn('subsubcategory_id');
            }

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

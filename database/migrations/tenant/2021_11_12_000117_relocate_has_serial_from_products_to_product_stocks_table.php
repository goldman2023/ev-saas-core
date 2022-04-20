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
        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'use_serial')) {
                $table->dropColumn('use_serial');
            }
        });

        Schema::table('product_stocks', function (Blueprint $table) {
            $table->tinyInteger('use_serial')->default(0)->after('low_stock_qty');
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
            $table->tinyInteger('use_serial')->default(0);
        });

        Schema::table('product_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('product_stocks', 'use_serial')) {
                $table->dropColumn('use_serial');
            }
        });
    }
};

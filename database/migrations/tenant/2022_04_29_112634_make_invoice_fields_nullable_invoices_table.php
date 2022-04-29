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
        Schema::table('invoices', function (Blueprint $table) {
            $table->integer('shop_id')->nullable(true)->change();
            $table->float('base_price', 8, 2)->nullable(true)->change();
            $table->float('discount_amount', 8, 2)->nullable(true)->change();
            $table->float('subtotal_price', 8, 2)->nullable(true)->change();
            $table->float('total_price', 8, 2)->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {

        });
    }
};

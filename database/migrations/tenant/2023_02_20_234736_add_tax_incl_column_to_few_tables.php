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
        Schema::table('orders', function (Blueprint $table) {
            $table->tinyInteger('tax_incl')->default(0)->after('tax')->comment('1 = Tax included in prices, 0 = Tax NOT included in prices');
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->tinyInteger('tax_incl')->default(0)->after('tax')->comment('1 = Tax included in prices, 0 = Tax NOT included in prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('few_tables', function (Blueprint $table) {
            //
        });
    }
};

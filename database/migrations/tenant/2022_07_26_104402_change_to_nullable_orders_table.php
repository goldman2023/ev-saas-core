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
            $table->string('billing_first_name', 255)->nullable()->change();
            $table->string('billing_last_name', 255)->nullable()->change();
            $table->string('billing_company', 255)->nullable()->change();
            $table->string('billing_address', 255)->nullable()->change();
            $table->string('billing_country', 255)->nullable()->change();
            $table->string('billing_state', 255)->nullable()->change();
            $table->string('billing_city', 255)->nullable()->change();
            $table->string('billing_zip', 255)->nullable()->change();
            $table->json('phone_numbers')->nullable()->change();
            $table->string('shipping_method', 255)->nullable()->change();
        });

        Schema::table('invoices', function (Blueprint $table) {
            $table->string('billing_first_name', 255)->nullable()->change();
            $table->string('billing_last_name', 255)->nullable()->change();
            $table->string('billing_company', 255)->nullable()->change();
            $table->string('billing_address', 255)->nullable()->change();
            $table->string('billing_country', 255)->nullable()->change();
            $table->string('billing_state', 255)->nullable()->change();
            $table->string('billing_city', 255)->nullable()->change();
            $table->string('billing_zip', 255)->nullable()->change();
            $table->integer('start_date')->nullable()->change();
            $table->integer('end_date')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};

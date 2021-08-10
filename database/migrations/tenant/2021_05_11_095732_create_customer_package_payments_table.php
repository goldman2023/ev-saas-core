<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerPackagePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_package_payments', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->integer('customer_package_id');
            $table->string('payment_method', 255);
            $table->longText('payment_details');
            $table->integer('approval');
            $table->integer('offline_payment')->comment('1=offline payment
2=online paymnet');
            $table->string('reciept', 150);
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
        Schema::dropIfExists('customer_package_payments');
    }
}

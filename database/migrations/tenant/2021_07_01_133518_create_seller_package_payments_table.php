<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSellerPackagePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('seller_package_payments')) return;
        Schema::create('seller_package_payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->nullable(false);
            $table->unsignedBigInteger('seller_package_id')->nullable(false);
            $table->string('payment_method')->nullable(false);
            $table->longText('payment_details')->nullable(false);
            $table->boolean('approval')->nullable(false)->default(0);
            $table->boolean('offline_payment')->comment('1=offline payment\r\n2=online paymnet')->nullable(false)->default(0);
            $table->string('reciept', 150);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seller_package_payments');
    }
}

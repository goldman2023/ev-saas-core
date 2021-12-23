<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPolymorphicRelationToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method_type')->after('user_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->after('payment_method_type')->nullable();

            $table->index(['payment_method_type', 'payment_method_id']);
        });

        Schema::dropIfExists('order_relationships');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method_type');
            $table->dropColumn('payment_method_id');
        });
    }
}

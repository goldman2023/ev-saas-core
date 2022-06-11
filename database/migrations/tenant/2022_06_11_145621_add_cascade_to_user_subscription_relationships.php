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
        Schema::table('user_subscription_relationships', function (Blueprint $table) {
            $table->dropForeign(['user_subscription_id']);
            $table->foreign('user_subscription_id')->references('id')->on('user_subscriptions')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_subscription_relationships', function (Blueprint $table) {
            //
        });
    }
};

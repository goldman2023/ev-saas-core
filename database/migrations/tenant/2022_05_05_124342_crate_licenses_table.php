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
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->string('license_name', 300)->nullable(true);
            $table->string('serial_number', 300)->nullable(true)->unique();
            $table->string('hardware_id', 300)->nullable(true)->unique();
            $table->string('license_type', 30)->default('trial')->index();
            $table->timestamps();
        });

        Schema::create('user_subscription_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_subscription_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type', 300);
            $table->timestamps();

            $table->index(['subject_id', 'subject_type']);
            $table->foreign('user_subscription_id')->references('id')->on('user_subscriptions')->onCascade('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};

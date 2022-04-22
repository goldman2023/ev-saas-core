<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type');
            $table->unsignedInteger('start_date')->nullable();
            $table->unsignedInteger('end_date')->nullable();
            $table->integer('qty')->default(1)->nullable(); // This should not exist probably beacuse we'l need 1 row for each subscription because we need to map other data to this model - like licenses for example
            $table->json('data')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['subject_id', 'subject_type']);
            $table->index('end_date');
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('CASCADE')->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_subscriptions');
    }
}

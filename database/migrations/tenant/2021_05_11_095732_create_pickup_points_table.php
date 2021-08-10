<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePickupPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pickup_points', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('staff_id');
            $table->string('name', 255);
            $table->text('address');
            $table->string('phone', 15);
            $table->integer('pick_up_status')->nullable();
            $table->integer('cash_on_pickup_status')->nullable();
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
        Schema::dropIfExists('pickup_points');
    }
}

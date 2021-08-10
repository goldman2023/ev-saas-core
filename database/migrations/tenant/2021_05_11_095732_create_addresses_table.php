<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->integer('id', true);
            $table->integer('user_id');
            $table->string('address', 255)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->string('postal_code', 255)->nullable();
            $table->string('phone', 255)->nullable();
            $table->integer('set_default')->default(0);
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
        Schema::dropIfExists('addresses');
    }
}

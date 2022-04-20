<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_methods_universal', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('enabled');
            $table->string('name', 255);
            $table->string('gateway', 255);
            $table->text('description');
            $table->text('instructions');
            $table->json('data');
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
        Schema::dropIfExists('payment_methods_universal');
    }
};

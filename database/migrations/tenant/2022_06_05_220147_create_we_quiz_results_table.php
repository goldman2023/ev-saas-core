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
        Schema::create('we_quiz_results', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->foreignId('quiz_id');
            $table->json('quiz_answers');
            $table->text('quiz_meta')->nullable();
            $table->boolean('quiz_passed')->default(false);
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
        Schema::dropIfExists('we_quiz_results');
    }
};

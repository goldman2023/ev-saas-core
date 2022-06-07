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
        Schema::create('ownerships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->string('owner_type', 255);
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type', 255);
            $table->json('data')->nullable();
            $table->timestamps();

            $table->index(['owner_id', 'owner_type']);
            $table->index(['subject_id', 'subject_type']);
            $table->index(['owner_id', 'owner_type', 'subject_id', 'subject_type']);

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ownership');
    }
};

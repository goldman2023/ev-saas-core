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
        Schema::create('section_relationships', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('type', 50);
            $table->string('status', 50);
            $table->unsignedBigInteger('section_id')->nullable();
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type', 200);
            $table->smallInteger('order')->unsigned()->default(0);
            $table->longtext('content')->nullable();
            $table->json('data')->nullable();
            $table->json('settings')->nullable();
            $table->timestamps();

            $table->index(['subject_id', 'subject_type']);
            $table->foreign('section_id')->references('id')->on('sections')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_relationships');
    }
};

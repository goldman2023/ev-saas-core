<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsContentRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads_content_relationships', function (Blueprint $table) {
            $table->id();
            $table->morphs('subject');
            $table->integer('upload_id');
            $table->foreign('upload_id')->references('id')->on('uploads')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('type');
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('uploads_groups')->onUpdate('CASCADE')->onDelete('RESTRICT');
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
        Schema::dropIfExists('uploads_content_relationships');
    }
}

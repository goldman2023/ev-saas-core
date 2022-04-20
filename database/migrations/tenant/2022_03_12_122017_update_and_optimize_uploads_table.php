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
        Schema::table('uploads_content_relationships', function (Blueprint $table) {
            $table->dropForeign(['upload_id']);
        });

        Schema::table('uploads', function (Blueprint $table) {
            $table->id('id')->change();
            $table->unsignedInteger('user_id')->change();
            $table->index(['type']);
        });

        Schema::table('uploads_content_relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('upload_id')->change();
            $table->foreign('upload_id')->references('id')->on('uploads')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};

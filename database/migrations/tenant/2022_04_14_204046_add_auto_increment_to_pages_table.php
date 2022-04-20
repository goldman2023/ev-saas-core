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
        try {
            Schema::table('page_previews', function (Blueprint $table) {
                $table->dropForeign('page_previews_page_id_foreign');
            });
        } catch (\Throwable $e) {
        }

        Schema::table('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('id', true)->nullable(false)->change();
        });

        try {
            Schema::table('page_previews', function (Blueprint $table) {
                $table->foreign('page_id')->references('id')->on('pages')->onUpdate('cascade')->onDelete('cascade');
            });
        } catch (\Throwable $e) {
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pages', function (Blueprint $table) {
            //
        });
    }
};

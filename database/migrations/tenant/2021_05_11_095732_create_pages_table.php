<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('type', 50);
            $table->string('title', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->longText('content')->nullable();
            $table->text('meta_title')->nullable();
            $table->string('meta_description', 1000)->nullable();
            $table->string('keywords', 1000)->nullable();
            $table->string('meta_image', 255)->nullable();
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
        Schema::dropIfExists('pages');
    }
}

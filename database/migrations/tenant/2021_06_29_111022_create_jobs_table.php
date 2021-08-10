<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->integer('shop_id');
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('CASCADE')->onDelete('RESTRICT');
            $table->string('title');
            $table->string('slug');
            $table->string('excerpt', 400);
            $table->longText('content');
            $table->index(['slug', 'shop_id']);
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
        Schema::dropIfExists('jobs');
    }
}

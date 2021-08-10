<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAffiliateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('affiliate_banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('banner');
            $table->string('campaign');
            $table->string('clicks');
            $table->string('refer_url');
            $table->integer('start_date');
            $table->integer('end_date');
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
        Schema::dropIfExists('affiliate_banners');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('frontend_color', 255)->default('default');
            $table->string('logo', 255)->nullable();
            $table->string('footer_logo', 255)->nullable();
            $table->string('admin_logo', 255)->nullable();
            $table->string('admin_login_background', 255)->nullable();
            $table->string('admin_login_sidebar', 255)->nullable();
            $table->string('favicon', 255)->nullable();
            $table->string('site_name', 255)->nullable();
            $table->string('address', 1000)->nullable();
            $table->mediumText('description');
            $table->string('phone', 100)->nullable();
            $table->string('email', 255)->nullable();
            $table->string('facebook', 1000)->nullable();
            $table->string('instagram', 1000)->nullable();
            $table->string('twitter', 1000)->nullable();
            $table->string('youtube', 1000)->nullable();
            $table->string('google_plus', 1000)->nullable();
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
        Schema::dropIfExists('general_settings');
    }
}

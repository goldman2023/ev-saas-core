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
        Schema::create('subscription_cancelations', function (Blueprint $table) {
            $table->id();

            $table->string('tenant_id')->nullable();
            $table->string('reason');

            $table->timestamps();

            $table->foreign('tenant_id')->references('id')->on('tenants')->onUpdate('set null')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscription_cancelations');
    }
};

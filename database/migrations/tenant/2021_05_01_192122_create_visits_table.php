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
        Schema::create('visits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('primary_key');
            $table->string('secondary_key')->nullable();
            $table->unsignedBigInteger('score');
            if (config('database.default') === 'pgsql') {
                $table->jsonb('list')->nullable();
            } else {
                $table->json('list')->nullable();
            }
            $table->timestamp('expired_at')->nullable();
            $table->timestamps();
            $table->unique(['primary_key', 'secondary_key']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visits');
    }
};

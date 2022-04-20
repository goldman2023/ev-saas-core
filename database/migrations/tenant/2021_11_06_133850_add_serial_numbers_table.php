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
        Schema::create('serial_numbers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject_type');
            $table->unsignedBigInteger('subject_id');
            $table->string('serial_number', 250)->nullable(false)->unique();
            $table->string('status', 250)->index();
            $table->timestamps();
            $table->timestamp('deleted_at', 0)->nullable(true);

            $table->index(['subject_type', 'subject_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->tinyInteger('use_serial')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('serial_numbers');

        Schema::table('products', function (Blueprint $table) {
            if (Schema::hasColumn('products', 'use_serial')) {
                $table->dropColumn('use_serial');
            }
        });
    }
};

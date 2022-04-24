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
        Schema::table('core_meta', function (Blueprint $table) {
            $table->string('value', 2500)->nullable()->change();
            $table->unique(['subject_id', 'subject_type', 'key']);
            $table->index(['subject_id', 'subject_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('core_meta', function (Blueprint $table) {
            $table->string('value', 191)->nullable(false)->change();
        });
    }
};

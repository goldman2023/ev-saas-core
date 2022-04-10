<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableToCoreMetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('core_meta', function (Blueprint $table) {
            $table->dropUnique(['subject_id', 'subject_type', 'key', 'value']);
            $table->dropIndex(['subject_id', 'subject_type', 'key']);
            // $table->string('value', 2500)->nullable()->change();

            // $table->unique(['subject_id', 'subject_type', 'key']);
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
            // $table->string('value', 191)->nullable(false)->change();
        });
    }
}

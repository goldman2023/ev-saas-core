<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeAttributeRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attribute_relationships', function (Blueprint $table) {
            $table->boolean('for_variations')->default(false)->after('attribute_value_id');
        });

        Schema::table('attributes', function (Blueprint $table) {
            //   $table->index('content_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attribute_relationships', function (Blueprint $table) {
            $table->dropColumn('for_variations');
        });

        Schema::table('attributes', function (Blueprint $table) {
            $table->dropIndex('content_type');
        });
    }
}

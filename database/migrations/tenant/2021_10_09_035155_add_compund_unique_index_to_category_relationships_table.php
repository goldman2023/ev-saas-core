<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompundUniqueIndexToCategoryRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('category_relationships', function (Blueprint $table) {
            $table->unique(['subject_id','subject_type','category_id'], 'category_relationship_polymorph_unique_identifier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('category_relationships', function (Blueprint $table) {
            $table->dropUnique('category_relationship_polymorph_unique_identifier');
        });
    }
}

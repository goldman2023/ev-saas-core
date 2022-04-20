<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeColumnOnUploadsContentRelationships extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('uploads_content_relationships', function (Blueprint $table) {
            if (Schema::hasColumn('uploads_content_relationships', 'type')) {
                $table->renameColumn('type', 'relation_type');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('uploads_content_relationships', function (Blueprint $table) {
            if (Schema::hasColumn('uploads_content_relationships', 'relation_type')) {
                $table->renameColumn('relation_type', 'type');
            }
        });
    }
}

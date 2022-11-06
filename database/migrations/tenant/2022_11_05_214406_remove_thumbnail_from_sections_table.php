<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sections', function (Blueprint $table) {
            if (Schema::hasColumn('sections', 'thumbnail')) {
                $table->dropColumn('thumbnail');
            }

            if (Schema::hasColumn('sections', 'section_id')) {
                $table->dropColumn('section_id');
            }

            if (!Schema::hasColumn('sections', 'content')) {
                $table->json('data')->nullable()->after('content');
            }

            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $doctrineTable = $sm->listTableDetails('sections');

            // if (!$doctrineTable->hasIndex('sections_slug_unique')) {
            //     $table->unique('slug');
            // }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sections', function (Blueprint $table) {
            //
        });
    }
};

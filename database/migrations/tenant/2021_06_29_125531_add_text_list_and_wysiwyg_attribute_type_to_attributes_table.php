<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTextListAndWysiwygAttributeTypeToAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('attributes', function (Blueprint $table) {
            // TODO: fix this one up :) Don't use vanilla SQL statements
            //DB::statement("ALTER TABLE attributes MODIFY COLUMN type ENUM('checkbox', 'dropdown', 'plain_text', 'country', 'number', 'date', 'text_list', 'wysiwyg')");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('attributes', function (Blueprint $table) {
            //
        });
    }
}

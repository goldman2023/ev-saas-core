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
        if (Schema::hasColumn('attributes', 'slug')) {
            Schema::table('attributes', function (Blueprint $table) {
                $table->dropColumn('slug'); //drop it if exists
            });
        }

        Schema::table('attributes', function (Blueprint $table) {
            $table->string('content_type', 255)->change();
            $table->index('content_type');
            $table->string('slug', 255)->index()->after('name');
            $table->string('type', 255)->change();
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
            $table->dropIndex(['content_type']);
            $table->dropColumn('slug');
            $table->enum('type', ['checkbox', 'dropdown', 'plain_text', 'country', 'option', 'other', 'number', 'date', 'image', 'radio', 'text_list', 'wysiwyg'])->change();
        });
    }
};

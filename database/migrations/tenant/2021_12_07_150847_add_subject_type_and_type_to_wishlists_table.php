<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubjectTypeAndTypeToWishlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wishlists', function (Blueprint $table) {
            //
            if (! Schema::hasColumn('wishlists', 'subject_type')) {
                $table->string('subject_type')->after('subject_id')->default(\App\Models\Product::class);
                $table->string('type')->after('subject_type');
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
        Schema::table('wishlists', function (Blueprint $table) {
            $table->dropColumn('subject_type');
            $table->dropColumn('type');
        });
    }
}

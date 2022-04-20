<?php

use App\Models\Category;
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
        $categories = Category::where('parent_id', '=', 0)->update(['parent_id' => null]);

        Schema::table('category_relationships', function (Blueprint $table) {
            if (Schema::hasColumn('category_relationships', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('category_relationships', 'updated_at')) {
                $table->dropColumn('updated_at');
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
    }
};

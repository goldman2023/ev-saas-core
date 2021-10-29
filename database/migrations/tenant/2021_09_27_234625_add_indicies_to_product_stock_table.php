<?php

use App\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndiciesToProductStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            if (Schema::hasColumn('product_stocks', 'subject_id')) {
                $table->unsignedBigInteger('subject_id')->after('id')->change();
            } else {
                $table->unsignedBigInteger('subject_id')->after('id');
            }

            if (Schema::hasColumn('product_stocks', 'subject_id')) {
                $table->string('subject_type')->nullable(false)->default(Product::class)->after('subject_id')->change();
            } else {
                $table->string('subject_type')->nullable(false)->default(Product::class)->after('subject_id');
            }

            $table->index(['subject_id', 'subject_type']);
            $table->unique('sku');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_stocks', function (Blueprint $table) {
            $table->dropIndex('product_stocks_subject_id_subject_type_index');
            $table->dropUnique('product_stocks_sku_unique');
        });
    }
}

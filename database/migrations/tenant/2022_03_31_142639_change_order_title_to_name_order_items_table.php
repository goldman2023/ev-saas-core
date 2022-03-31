<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeOrderTitleToNameOrderItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            if(Schema::hasColumn('order_items', 'title')) {
                $table->renameColumn('title', 'name');
            }
            $table->json('serial_numbers')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            if(Schema::hasColumn('order_items', 'name')) {
                $table->renameColumn('name', 'title');
            }
            $table->json('serial_numbers')->nullable(false)->change();
        });
    }
}

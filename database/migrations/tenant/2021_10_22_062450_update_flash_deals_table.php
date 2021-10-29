<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateFlashDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('flash_deals', function (Blueprint $table) {
            $table->bigIncrements('id')->change();
            $table->unsignedInteger('start_date')->change();
            $table->unsignedInteger('end_date')->change();
            //$table->tinyInteger('status')->change();
            //$table->tinyInteger('featured')->change();

            if (!Schema::hasColumn('flash_deals', 'deleted_at')) {
                $table->timestamp('deleted_at')->nullable(true)->after('updated_at');
            }

            if (!Schema::hasColumn('flash_deals', 'business_id')) {
                // foreign key to business
                $table->integer('business_id')->nullable(false)->after('id');
                $table->foreign('business_id')
                    ->references('id')
                    ->on('shops')
                    ->onUpdate('cascade')
                    ->onDelete('cascade');
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
        //
    }
}

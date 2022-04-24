<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('shop_id')->after('name')->nullable(true); //->default(5);
            $table->foreign('shop_id')
                ->references('id')
                ->on('shops')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unsignedInteger('user_id')->nullable(true)->change();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('set null'); // TODO: If user is removed, products which user added will set user_id to NULL. Don't forget to add getUserIdAttribute function and check if user_id is null. If yes, get the main seller id, otherwise retrieve user_id
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_shop_id_foreign');
            $table->dropColumn('shop_id');
        });
    }
};

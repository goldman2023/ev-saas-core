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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('verified')->after('user_type')->default(0);
            $table->string('stripe_customer_id')->after('verified')->nullable();
            $table->dropColumn('avatar');
            $table->dropColumn('avatar_original');
            $table->dropColumn('address');
            $table->dropColumn('country');
            $table->dropColumn('city');
            $table->dropColumn('postal_code');
            $table->dropColumn('customer_package_id');
            $table->dropColumn('remaining_uploads');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->boolean('verified')->after('slug')->default(0); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('stripe_customer_id');
            $table->dropColumn('verified');
        });

        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn('verified'); 
        });
    }
};

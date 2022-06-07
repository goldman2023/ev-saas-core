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
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }

            if (Schema::hasColumn('users', 'avatar_original')) {
                $table->dropColumn('avatar_original');
            }

            if (Schema::hasColumn('users', 'address')) {
                $table->dropColumn('address');
            }

            if (Schema::hasColumn('users', 'country')) {
                $table->dropColumn('country');
            }

            if (Schema::hasColumn('users', 'city')) {
                $table->dropColumn('city');
            }

            if (Schema::hasColumn('users', 'postal_code')) {
                $table->dropColumn('postal_code');
            }

            if (Schema::hasColumn('users', 'customer_package_id')) {
                $table->dropColumn('customer_package_id');
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

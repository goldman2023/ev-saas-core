<?php

use App\Enums\AmountPercentTypeEnum;
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
        Schema::table('plans', function (Blueprint $table) {
            $table->double('yearly_discount')->default(0)->nullable()->after('discount_type');
            $table->string('yearly_discount_type')->default(AmountPercentTypeEnum::percent()->value)->nullable()->after('yearly_discount');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('plans', function (Blueprint $table) {
            $table->dropColumn('yearly_discount');
            $table->dropColumn('yearly_discount_type');
        });
    }
};

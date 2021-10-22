<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxCountryBusinessRelationshipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('shops', 'businesses');
        Schema::table('businesses', function (Blueprint $table) {
            if (Schema::hasColumn('businesses', 'shipping_cost')) {
                $table->dropColumn('shipping_cost');
            }
        });

        Schema::table('taxes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->change();
            $table->integer('business_id')->nullable(false);
            $table->float('tax')->nullable(false)->after('name');
            $table->enum('type', ['amount', 'percent'])->default('percent')->after('tax')->nullable(false);

            $table->foreign('business_id')
                ->references('id')
                ->on('businesses')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::create('tax_relationships', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->primary();

            $table->integer('country_id')->nullable(true);
            $table->foreign('country_id')
                ->references('id')
                ->on('countries')
                ->onUpdate('cascade')
                ->onDelete('restrict'); // restrict removing a country if taxes for that country are present!

            $table->foreignId('tax_id')
                ->constrained('taxes')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->timestamps();

            $table->index(['tax_id', 'country_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_relationships');
        Schema::rename('businesses', 'shops');

        Schema::table('taxes', function (Blueprint $table) {
            $table->dropColumn('business_id');
            $table->dropColumn('tax');
            $table->dropColumn('type');
        });
    }

}

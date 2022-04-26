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
        /* Content types for core meta:
            Product
            Order
            Customer
            Blog
            Categories
            */
        Schema::create('core_meta', function (Blueprint $table) {
            // Example of structue
            // subject_id / 5
            // sales_channel / wc
            // sales_channel / shopify
            // Prefix for _id is sales channel name
            // wc_id / 1234563
            // shopify_id / 1234563
            $table->id();
            $table->string('key');
            $table->string('value');
            $table->string('subject_type'); // = Product / Order / Customer / Blog / Category
            $table->string('subject_id');
            $table->index(['subject_id', 'subject_type', 'key']);
            $table->unique(['subject_id', 'subject_type', 'key', 'value']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('core_meta');
    }
};

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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('payment_method_type');
            $table->dropColumn('payment_method_id');
            $table->dropColumn('base_price');
            $table->dropColumn('discount_amount');
            $table->dropColumn('subtotal_price');
            $table->dropColumn('total_price');
            $table->string('shipping_method')->change();

            // New
            $table->string('type', 50)->after('user_id')->index(); // standard, installments, subscription
            $table->text('terms')->after('note')->nullable(true);
            $table->integer('number_of_invoices')->default(0)->after('terms');
            $table->string('invoicing_period')->after('number_of_invoices'); // Carbon period string
            $table->string('invoice_grace_period')->nullable(true)->after('invoicing_period'); // Carbon period string
            $table->timestamp('invoicing_start_date')->useCurrent()->after('invoice_grace_period'); // timestamp converted to unixtimestamp
        });

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable(true);
            $table->integer('shop_id');
            $table->unsignedInteger('user_id')->nullable();

            $table->string('payment_method_type')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();

            $table->string('invoice_number', 255)->nullable(true)->unique(); // ID can be used instead of invoice_number

            // Invoice data columns (usually copied from the Order data) - THIS IS FIXED!
            $table->string('email', 255)->index();
            $table->string('billing_first_name', 255);
            $table->string('billing_last_name', 255);
            $table->string('billing_company', 255)->nullable();
            $table->string('billing_address', 255);
            $table->string('billing_country', 255);
            $table->string('billing_state', 255);
            $table->string('billing_city', 255);
            $table->string('billing_zip', 255);

            // Invoice amounts columns (if installments: sum of order_items divided by number of installments/invoices; if subscription: amount per period)
            $table->float('base_price');
            $table->float('discount_amount');
            $table->float('subtotal_price');
            $table->float('total_price');

            $table->float('shipping_cost')->default(0); // TODO: No idea if needed here at all...
            $table->float('tax')->default(0); // TODO: No idea if needed here at all...

            // Invoice specific columns
            $table->string('payment_status', 25)->default('unpaid');

            $table->timestamp('due_date')->index();
            $table->string('grace_period');

            $table->boolean('viewed_by_customer')->default(0);

            $table->json('meta');
            $table->string('note', 500);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade')->onUpdate('cascade'); // when order is removed, remove invoices
            $table->foreign('shop_id')->references('id')->on('shops')->onDelete('cascade')->onUpdate('cascade'); // When shop is removed, it's orders are removed
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null')->onUpdate('set null'); // When user is removed, Set relation to NULL (We DON'T want to remove orders when user is removed!)
            $table->index(['payment_method_type', 'payment_method_id']); // Index payment_method_type and payment_method_id. Each invoice can be payed with a different payment method!
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
};

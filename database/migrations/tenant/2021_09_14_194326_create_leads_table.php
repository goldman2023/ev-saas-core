<?php

use App\Models\Lead;
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
        if (Schema::hasTable('leads')) {
            Schema::table('leads', function (Blueprint $table) {
                if (Schema::hasColumn('leads', 'user_id')) {
                    $table->dropColumn('user_id');
                }

                if (! Schema::hasColumn('leads', 'business_id')) {
                    $table->integer('business_id')->nullable(true)->after('id');
                    $table->foreign('business_id')
                        ->references('id')
                        ->on('shops')
                        ->onUpdate('cascade')
                        ->onDelete('cascade');
                }
            });
        } else {
            Schema::create('leads', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->nullable();
                $table->string('name')->nullable();
                $table->string('email')->nullable();
                $table->string('status')->default('new');
                $table->text('message')->nullable();
                $table->text('attributes')->nullable();
                $table->integer('user_id')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leads');
    }
};

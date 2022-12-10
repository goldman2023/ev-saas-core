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
        Schema::create('task_relationships', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->string('subject_type', 200)->nullable();
            $table->unsignedBigInteger('task_id');
            $table->timestamps();

            $table->index(['subject_id', 'subject_type']);
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });

        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'subject_id')) {
                $table->dropColumn('subject_id');
            }

            if (Schema::hasColumn('tasks', 'subject_type')) {
                $table->dropColumn('subject_type');
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
        Schema::dropIfExists('task_relationships');
    }
};

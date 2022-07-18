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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type',255); 
            $table->unsignedInteger('user_id'); 
            $table->unsignedInteger('assignee_id'); 
            $table->string('type',100); 
            $table->string('status',100); 
            $table->string('name',300); 
            $table->string('excerpt',500); 
            $table->longText('content',500); 
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            $table->timestamps();

            $table->unique('type');
            $table->unique('status');


            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->foreign('assignee_id')
                ->references('id')
                ->on('users')
                ->onUpdate('restrict')
                ->onDelete('cascade');

            $table->index(['subject_type', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
};

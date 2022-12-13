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
        Schema::table('tasks', function (Blueprint $table) {
            if (Schema::hasColumn('tasks', 'excerpt')) {
                $table->string('excerpt', 500)->nullable()->change();
            }

            if (Schema::hasColumn('tasks', 'content')) {
                $table->longText('content')->nullable()->change();
            }

            if (Schema::hasColumn('tasks', 'assignee_id')) {
                $table->unsignedInteger('assignee_id')->nullable()->change();
            }

            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexesFound = $sm->listTableIndexes('tasks');

            if(array_key_exists("tasks_status_unique", $indexesFound)) {
                $table->dropUnique("tasks_status_unique");
                $table->index(['status']);
            }

            if(array_key_exists("tasks_type_unique", $indexesFound)) {
                $table->dropUnique("tasks_type_unique");
                $table->index(['type']);
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
        //
    }
};

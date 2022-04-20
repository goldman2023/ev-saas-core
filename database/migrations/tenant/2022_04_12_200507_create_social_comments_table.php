<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (! Schema::hasTable('social_comments')) {
            Schema::create('social_comments', function (Blueprint $table) {
                $table->id();
                $table->unsignedInteger('user_id');
                $table->integer('shop_id')->nullable();
                $table->text('comment_text');
                $table->timestamps();

                $table->foreignId('parent_id')->nullable()->references('id')->on('social_comments');
                $table->unsignedBigInteger('subject_id');
                $table->string('subject_type');

                $table->index(['subject_id', 'subject_type']);
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
        Schema::dropIfExists('social_comments');
    }
}

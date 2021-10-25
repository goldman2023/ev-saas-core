<?php

use App\Models\Shop;
use App\Models\UserRelationship;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RefactorBusinessUserRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $businesses = Shop::all();

        Schema::create('user_relationships', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('user_id'); // TODO: Make 'id' in users table an UNSIGNED BIGINT!
            $table->unsignedBigInteger('subject_id');
            $table->string('subject_type');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
        });

        foreach($businesses as $business) {
            $rel = new UserRelationship();
            $rel->user_id = $business->user_id;
            $rel->subject_id = $business->id;
            $rel->subject_type = Shop::class;
            $rel->save();
        }

        Schema::table('businesses', function (Blueprint $table) {
            if (Schema::hasColumn('businesses', 'user_id')) {
                $table->dropColumn('user_id');
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
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('review_relationships')->count() == 0) {
            \DB::table('review_relationships')->delete();

            \DB::table('review_relationships')->insert([
                0 => [
                        'id' => 1,
                        'subject_type' => \App\Models\Shop::class,
                        'subject_id' => 1,
                        'review_id' => 1,
                        'creator_id' => 1,
                        'created_at' => '2021-05-26 11:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ],
                1 => [
                        'id' => 2,
                        'subject_type' => \App\Models\Shop::class,
                        'subject_id' => 1,
                        'review_id' => 2,
                        'creator_id' => 2,
                        'created_at' => '2021-05-26 11:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ],
                2 => [
                        'id' => 3,
                        'subject_type' => \App\Models\Shop::class,
                        'subject_id' => 1,
                        'review_id' => 3,
                        'creator_id' => 3,
                        'created_at' => '2021-05-26 11:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ],
                3 => [
                        'id' => 4,
                        'subject_type' => \App\Models\Shop::class,
                        'subject_id' => 1,
                        'review_id' => 4,
                        'creator_id' => 1,
                        'created_at' => '2021-05-26 11:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ],
            ]);
        }
    }
}

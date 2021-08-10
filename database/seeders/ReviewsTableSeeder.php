<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('reviews')->count() == 0) {
            \DB::table('reviews')->delete();

            \DB::table('reviews')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'rating' => 5,
                        'comment' => '5 mark rating test',
                        'status' => 1,
                        'viewed' => 0,
                        'content_type' => 'App\Models\Shop',
                        'created_at' => '2021-05-26 10:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'rating' => 4,
                        'comment' => '4 mark rating test',
                        'status' => 1,
                        'viewed' => 0,
                        'content_type' => 'App\Models\Shop',
                        'created_at' => '2021-05-26 10:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'rating' => 2,
                        'comment' => '2 mark rating test',
                        'status' => 1,
                        'viewed' => 1,
                        'content_type' => 'App\Models\Shop',
                        'created_at' => '2021-05-26 10:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'rating' => 5,
                        'comment' => '5 mark rating test 1',
                        'status' => 1,
                        'viewed' => 1,
                        'content_type' => 'App\Models\Shop',
                        'created_at' => '2021-05-26 10:52:46',
                        'updated_at' => '2021-05-26 11:01:41',
                    ),
            ));
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class BannersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('banners')->count() == 0) {
            \DB::table('banners')->delete();

            \DB::table('banners')->insert(array(
                0 =>
                    array(
                        'id' => 4,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 1,
                        'published' => 1,
                        'created_at' => '2019-03-12 07:58:23',
                        'updated_at' => '2019-06-11 07:56:50',
                    ),
                1 =>
                    array(
                        'id' => 5,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 1,
                        'published' => 1,
                        'created_at' => '2019-03-12 07:58:41',
                        'updated_at' => '2019-03-12 07:58:57',
                    ),
                2 =>
                    array(
                        'id' => 6,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 2,
                        'published' => 1,
                        'created_at' => '2019-03-12 07:58:52',
                        'updated_at' => '2019-03-12 07:58:57',
                    ),
                3 =>
                    array(
                        'id' => 7,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 2,
                        'published' => 1,
                        'created_at' => '2019-05-26 08:16:38',
                        'updated_at' => '2019-05-26 08:17:34',
                    ),
                4 =>
                    array(
                        'id' => 8,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 2,
                        'published' => 1,
                        'created_at' => '2019-06-11 08:00:06',
                        'updated_at' => '2019-06-11 08:00:27',
                    ),
                5 =>
                    array(
                        'id' => 9,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 1,
                        'published' => 1,
                        'created_at' => '2019-06-11 08:00:15',
                        'updated_at' => '2019-06-11 08:00:29',
                    ),
                6 =>
                    array(
                        'id' => 10,
                        'photo' => 'uploads/banners/banner.jpg',
                        'url' => '#',
                        'position' => 1,
                        'published' => 0,
                        'created_at' => '2019-06-11 08:00:24',
                        'updated_at' => '2019-06-11 08:01:56',
                    ),
            ));
        }

    }
}

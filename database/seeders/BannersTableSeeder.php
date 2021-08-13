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
            ));
        }

    }
}

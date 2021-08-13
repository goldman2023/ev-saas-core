<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SlidersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('sliders')->count() == 0) {
            \DB::table('sliders')->delete();

            /* TODO: DO we even need this? We are not using this functionality maybe we can remove this */
            \DB::table('sliders')->insert(array(
               /* 0 =>
                    array(
                        'id' => 7,
                        'photo' => 'uploads/sliders/slider-image.jpg',
                        'published' => 1,
                        'link' => NULL,
                        'created_at' => '2019-03-12 07:58:05',
                        'updated_at' => '2019-03-12 07:58:05',
                    ),*/

            ));
        }

    }
}

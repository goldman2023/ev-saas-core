<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShopsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('shops')->count() == 0) {
            \DB::table('shops')->delete();

            /* TODO: Create reasonable shop seeder - Admin user, main tenant, should have default shop on seeder */
            /* \DB::table('shops')->insert(array(

            )); */

            \DB::table('user_relationships')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'user_id' => 1,
                        'subject_id' => 1,
                        'subject_type' => 'App\\Models\\Shop',
                    ),
            ));

        }
    }
}

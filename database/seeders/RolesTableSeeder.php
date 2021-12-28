<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('roles')->count() == 0) {
            \DB::table('roles')->delete();

            \DB::table('roles')->insert(array(
                /* TODO: Create a seeder */
            ));
        }

    }
}

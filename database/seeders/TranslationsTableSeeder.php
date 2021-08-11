<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('translations')->count() == 0) {
            \DB::table('translations')->delete();

            /* TODO: maybe create dynamic seeder for setting up labels */

        }
    }
}

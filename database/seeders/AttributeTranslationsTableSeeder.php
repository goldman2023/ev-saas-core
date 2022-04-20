<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeTranslationsTableSeeder extends Seeder
{
    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('attribute_translations')->count() == 0) {
            /* Note: Translations are not required in initial seeder */
        }
    }
}

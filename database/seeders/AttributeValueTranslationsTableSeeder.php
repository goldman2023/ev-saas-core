<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeValueTranslationsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('attribute_value_translations')->count() == 0) {
//            \DB::table('attribute_value_translations')->delete();
        }

    }
}

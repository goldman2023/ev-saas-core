<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeValuesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('attribute_values')->count() == 0) {
            \DB::table('attribute_values')->delete();

            /* TODO: We need a reasonable initial attributes list, maybe that should be done by specific industries/cases? */
            \DB::table('attribute_values')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'attribute_id' => 1,
                        'values' => 'Demo Value',
                        'created_at' => '2021-05-19 12:09:10',
                        'updated_at' => '2021-06-01 15:26:27',
                    ),


            ));
        }

    }
}

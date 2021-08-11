<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AttributeRelationshipsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('attribute_relationships')->count() == 0) {
            \DB::table('attribute_relationships')->delete();

            \DB::table('attribute_relationships')->insert(array(
                /* Just an example relationship */
                0 =>
                    array(
                        'id' => 1,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 1,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
            ));
        }
    }
}

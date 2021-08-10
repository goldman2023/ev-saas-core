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
                0 =>
                    array(
                        'id' => 1,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 1,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 1,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 1,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 2,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 2,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 2,
                        'attribute_id' => 3,
                        'attribute_value_id' => 5,
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 2,
                        'attribute_id' => 4,
                        'attribute_value_id' => 9,
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 2,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 3,
                        'attribute_id' => 1,
                        'attribute_value_id' => 3,
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 3,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 3,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 4,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 4,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 4,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 4,
                        'attribute_id' => 4,
                        'attribute_value_id' => 9,
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 4,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 5,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 5,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 5,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 5,
                        'attribute_id' => 4,
                        'attribute_value_id' => 10,
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 5,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 6,
                        'attribute_id' => 1,
                        'attribute_value_id' => 3,
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 6,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 6,
                        'attribute_id' => 3,
                        'attribute_value_id' => 8,
                    ),
                24 =>
                    array(
                        'id' => 25,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 6,
                        'attribute_id' => 4,
                        'attribute_value_id' => 11,
                    ),
                25 =>
                    array(
                        'id' => 26,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 6,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                26 =>
                    array(
                        'id' => 27,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 7,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                27 =>
                    array(
                        'id' => 28,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 7,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                28 =>
                    array(
                        'id' => 29,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 7,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                29 =>
                    array(
                        'id' => 30,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 7,
                        'attribute_id' => 4,
                        'attribute_value_id' => 9,
                    ),
                30 =>
                    array(
                        'id' => 31,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 7,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                31 =>
                    array(
                        'id' => 32,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 8,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                32 =>
                    array(
                        'id' => 33,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 8,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                33 =>
                    array(
                        'id' => 34,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 8,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                34 =>
                    array(
                        'id' => 35,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 8,
                        'attribute_id' => 4,
                        'attribute_value_id' => 10,
                    ),
                35 =>
                    array(
                        'id' => 36,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 8,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                36 =>
                    array(
                        'id' => 37,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 9,
                        'attribute_id' => 1,
                        'attribute_value_id' => 3,
                    ),
                37 =>
                    array(
                        'id' => 38,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 9,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                38 =>
                    array(
                        'id' => 39,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 9,
                        'attribute_id' => 3,
                        'attribute_value_id' => 8,
                    ),
                39 =>
                    array(
                        'id' => 40,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 9,
                        'attribute_id' => 4,
                        'attribute_value_id' => 11,
                    ),
                40 =>
                    array(
                        'id' => 41,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 9,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                41 =>
                    array(
                        'id' => 42,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 10,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                42 =>
                    array(
                        'id' => 43,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 10,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                43 =>
                    array(
                        'id' => 44,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 10,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                44 =>
                    array(
                        'id' => 45,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 10,
                        'attribute_id' => 4,
                        'attribute_value_id' => 12,
                    ),
                45 =>
                    array(
                        'id' => 46,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 10,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                46 =>
                    array(
                        'id' => 47,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 11,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                47 =>
                    array(
                        'id' => 48,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 11,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                48 =>
                    array(
                        'id' => 49,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 11,
                        'attribute_id' => 3,
                        'attribute_value_id' => 8,
                    ),
                49 =>
                    array(
                        'id' => 50,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 11,
                        'attribute_id' => 4,
                        'attribute_value_id' => 13,
                    ),
                50 =>
                    array(
                        'id' => 51,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 11,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                51 =>
                    array(
                        'id' => 52,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 12,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                52 =>
                    array(
                        'id' => 53,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 12,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                53 =>
                    array(
                        'id' => 54,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 12,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                54 =>
                    array(
                        'id' => 55,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 12,
                        'attribute_id' => 4,
                        'attribute_value_id' => 9,
                    ),
                55 =>
                    array(
                        'id' => 56,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 12,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                56 =>
                    array(
                        'id' => 57,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 13,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                57 =>
                    array(
                        'id' => 58,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 13,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                58 =>
                    array(
                        'id' => 59,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 13,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                59 =>
                    array(
                        'id' => 60,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 13,
                        'attribute_id' => 4,
                        'attribute_value_id' => 10,
                    ),
                60 =>
                    array(
                        'id' => 61,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 13,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                61 =>
                    array(
                        'id' => 62,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 14,
                        'attribute_id' => 1,
                        'attribute_value_id' => 3,
                    ),
                62 =>
                    array(
                        'id' => 63,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 14,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                63 =>
                    array(
                        'id' => 64,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 14,
                        'attribute_id' => 3,
                        'attribute_value_id' => 8,
                    ),
                64 =>
                    array(
                        'id' => 65,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 14,
                        'attribute_id' => 4,
                        'attribute_value_id' => 11,
                    ),
                65 =>
                    array(
                        'id' => 66,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 14,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                66 =>
                    array(
                        'id' => 67,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 15,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                67 =>
                    array(
                        'id' => 68,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 15,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                68 =>
                    array(
                        'id' => 69,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 15,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                69 =>
                    array(
                        'id' => 70,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 15,
                        'attribute_id' => 4,
                        'attribute_value_id' => 12,
                    ),
                70 =>
                    array(
                        'id' => 71,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 15,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                71 =>
                    array(
                        'id' => 72,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 16,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                72 =>
                    array(
                        'id' => 73,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 16,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                73 =>
                    array(
                        'id' => 74,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 16,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                74 =>
                    array(
                        'id' => 75,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 16,
                        'attribute_id' => 4,
                        'attribute_value_id' => 13,
                    ),
                75 =>
                    array(
                        'id' => 76,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 16,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                76 =>
                    array(
                        'id' => 77,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 17,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                77 =>
                    array(
                        'id' => 78,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 17,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                78 =>
                    array(
                        'id' => 79,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 17,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                79 =>
                    array(
                        'id' => 80,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 17,
                        'attribute_id' => 4,
                        'attribute_value_id' => 9,
                    ),
                80 =>
                    array(
                        'id' => 81,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 17,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                81 =>
                    array(
                        'id' => 82,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 18,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                82 =>
                    array(
                        'id' => 83,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 18,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                83 =>
                    array(
                        'id' => 84,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 18,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                84 =>
                    array(
                        'id' => 85,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 18,
                        'attribute_id' => 4,
                        'attribute_value_id' => 10,
                    ),
                85 =>
                    array(
                        'id' => 86,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 18,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                86 =>
                    array(
                        'id' => 87,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 19,
                        'attribute_id' => 1,
                        'attribute_value_id' => 3,
                    ),
                87 =>
                    array(
                        'id' => 88,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 19,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                88 =>
                    array(
                        'id' => 89,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 19,
                        'attribute_id' => 3,
                        'attribute_value_id' => 8,
                    ),
                89 =>
                    array(
                        'id' => 90,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 19,
                        'attribute_id' => 4,
                        'attribute_value_id' => 11,
                    ),
                90 =>
                    array(
                        'id' => 91,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 19,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
                91 =>
                    array(
                        'id' => 92,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 20,
                        'attribute_id' => 1,
                        'attribute_value_id' => 1,
                    ),
                92 =>
                    array(
                        'id' => 93,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 20,
                        'attribute_id' => 2,
                        'attribute_value_id' => 5,
                    ),
                93 =>
                    array(
                        'id' => 94,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 20,
                        'attribute_id' => 3,
                        'attribute_value_id' => 6,
                    ),
                94 =>
                    array(
                        'id' => 95,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 20,
                        'attribute_id' => 4,
                        'attribute_value_id' => 12,
                    ),
                95 =>
                    array(
                        'id' => 96,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 20,
                        'attribute_id' => 5,
                        'attribute_value_id' => 15,
                    ),
                96 =>
                    array(
                        'id' => 97,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 21,
                        'attribute_id' => 1,
                        'attribute_value_id' => 2,
                    ),
                97 =>
                    array(
                        'id' => 98,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 21,
                        'attribute_id' => 2,
                        'attribute_value_id' => 4,
                    ),
                98 =>
                    array(
                        'id' => 99,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 21,
                        'attribute_id' => 3,
                        'attribute_value_id' => 7,
                    ),
                99 =>
                    array(
                        'id' => 100,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 21,
                        'attribute_id' => 4,
                        'attribute_value_id' => 13,
                    ),
                100 =>
                    array(
                        'id' => 101,
                        'subject_type' => 'App\Models\Seller',
                        'subject_id' => 21,
                        'attribute_id' => 5,
                        'attribute_value_id' => 14,
                    ),
            ));
        }
    }
}

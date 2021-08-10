<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('colors')->count() == 0) {
            \DB::table('colors')->delete();

            \DB::table('colors')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'name' => 'IndianRed',
                        'code' => '#CD5C5C',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'name' => 'LightCoral',
                        'code' => '#F08080',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'name' => 'Salmon',
                        'code' => '#FA8072',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'name' => 'DarkSalmon',
                        'code' => '#E9967A',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'name' => 'LightSalmon',
                        'code' => '#FFA07A',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'name' => 'Crimson',
                        'code' => '#DC143C',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'name' => 'Red',
                        'code' => '#FF0000',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'name' => 'FireBrick',
                        'code' => '#B22222',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'name' => 'DarkRed',
                        'code' => '#8B0000',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'name' => 'Pink',
                        'code' => '#FFC0CB',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'name' => 'LightPink',
                        'code' => '#FFB6C1',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'name' => 'HotPink',
                        'code' => '#FF69B4',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'name' => 'DeepPink',
                        'code' => '#FF1493',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'name' => 'MediumVioletRed',
                        'code' => '#C71585',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'name' => 'PaleVioletRed',
                        'code' => '#DB7093',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'name' => 'LightSalmon',
                        'code' => '#FFA07A',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'name' => 'Coral',
                        'code' => '#FF7F50',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'name' => 'Tomato',
                        'code' => '#FF6347',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'name' => 'OrangeRed',
                        'code' => '#FF4500',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'name' => 'DarkOrange',
                        'code' => '#FF8C00',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'name' => 'Orange',
                        'code' => '#FFA500',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'name' => 'Gold',
                        'code' => '#FFD700',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'name' => 'Yellow',
                        'code' => '#FFFF00',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'name' => 'LightYellow',
                        'code' => '#FFFFE0',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                24 =>
                    array(
                        'id' => 25,
                        'name' => 'LemonChiffon',
                        'code' => '#FFFACD',
                        'created_at' => '2018-11-05 04:12:26',
                        'updated_at' => '2018-11-05 04:12:26',
                    ),
                25 =>
                    array(
                        'id' => 26,
                        'name' => 'LightGoldenrodYellow',
                        'code' => '#FAFAD2',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                26 =>
                    array(
                        'id' => 27,
                        'name' => 'PapayaWhip',
                        'code' => '#FFEFD5',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                27 =>
                    array(
                        'id' => 28,
                        'name' => 'Moccasin',
                        'code' => '#FFE4B5',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                28 =>
                    array(
                        'id' => 29,
                        'name' => 'PeachPuff',
                        'code' => '#FFDAB9',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                29 =>
                    array(
                        'id' => 30,
                        'name' => 'PaleGoldenrod',
                        'code' => '#EEE8AA',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                30 =>
                    array(
                        'id' => 31,
                        'name' => 'Khaki',
                        'code' => '#F0E68C',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                31 =>
                    array(
                        'id' => 32,
                        'name' => 'DarkKhaki',
                        'code' => '#BDB76B',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                32 =>
                    array(
                        'id' => 33,
                        'name' => 'Lavender',
                        'code' => '#E6E6FA',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                33 =>
                    array(
                        'id' => 34,
                        'name' => 'Thistle',
                        'code' => '#D8BFD8',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                34 =>
                    array(
                        'id' => 35,
                        'name' => 'Plum',
                        'code' => '#DDA0DD',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                35 =>
                    array(
                        'id' => 36,
                        'name' => 'Violet',
                        'code' => '#EE82EE',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                36 =>
                    array(
                        'id' => 37,
                        'name' => 'Orchid',
                        'code' => '#DA70D6',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                37 =>
                    array(
                        'id' => 38,
                        'name' => 'Fuchsia',
                        'code' => '#FF00FF',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                38 =>
                    array(
                        'id' => 39,
                        'name' => 'Magenta',
                        'code' => '#FF00FF',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                39 =>
                    array(
                        'id' => 40,
                        'name' => 'MediumOrchid',
                        'code' => '#BA55D3',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                40 =>
                    array(
                        'id' => 41,
                        'name' => 'MediumPurple',
                        'code' => '#9370DB',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                41 =>
                    array(
                        'id' => 42,
                        'name' => 'Amethyst',
                        'code' => '#9966CC',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                42 =>
                    array(
                        'id' => 43,
                        'name' => 'BlueViolet',
                        'code' => '#8A2BE2',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                43 =>
                    array(
                        'id' => 44,
                        'name' => 'DarkViolet',
                        'code' => '#9400D3',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                44 =>
                    array(
                        'id' => 45,
                        'name' => 'DarkOrchid',
                        'code' => '#9932CC',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                45 =>
                    array(
                        'id' => 46,
                        'name' => 'DarkMagenta',
                        'code' => '#8B008B',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                46 =>
                    array(
                        'id' => 47,
                        'name' => 'Purple',
                        'code' => '#800080',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                47 =>
                    array(
                        'id' => 48,
                        'name' => 'Indigo',
                        'code' => '#4B0082',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                48 =>
                    array(
                        'id' => 49,
                        'name' => 'SlateBlue',
                        'code' => '#6A5ACD',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                49 =>
                    array(
                        'id' => 50,
                        'name' => 'DarkSlateBlue',
                        'code' => '#483D8B',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                50 =>
                    array(
                        'id' => 51,
                        'name' => 'MediumSlateBlue',
                        'code' => '#7B68EE',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                51 =>
                    array(
                        'id' => 52,
                        'name' => 'GreenYellow',
                        'code' => '#ADFF2F',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                52 =>
                    array(
                        'id' => 53,
                        'name' => 'Chartreuse',
                        'code' => '#7FFF00',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                53 =>
                    array(
                        'id' => 54,
                        'name' => 'LawnGreen',
                        'code' => '#7CFC00',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                54 =>
                    array(
                        'id' => 55,
                        'name' => 'Lime',
                        'code' => '#00FF00',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                55 =>
                    array(
                        'id' => 56,
                        'name' => 'LimeGreen',
                        'code' => '#32CD32',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                56 =>
                    array(
                        'id' => 57,
                        'name' => 'PaleGreen',
                        'code' => '#98FB98',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                57 =>
                    array(
                        'id' => 58,
                        'name' => 'LightGreen',
                        'code' => '#90EE90',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                58 =>
                    array(
                        'id' => 59,
                        'name' => 'MediumSpringGreen',
                        'code' => '#00FA9A',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                59 =>
                    array(
                        'id' => 60,
                        'name' => 'SpringGreen',
                        'code' => '#00FF7F',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                60 =>
                    array(
                        'id' => 61,
                        'name' => 'MediumSeaGreen',
                        'code' => '#3CB371',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                61 =>
                    array(
                        'id' => 62,
                        'name' => 'SeaGreen',
                        'code' => '#2E8B57',
                        'created_at' => '2018-11-05 04:12:27',
                        'updated_at' => '2018-11-05 04:12:27',
                    ),
                62 =>
                    array(
                        'id' => 63,
                        'name' => 'ForestGreen',
                        'code' => '#228B22',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                63 =>
                    array(
                        'id' => 64,
                        'name' => 'Green',
                        'code' => '#008000',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                64 =>
                    array(
                        'id' => 65,
                        'name' => 'DarkGreen',
                        'code' => '#006400',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                65 =>
                    array(
                        'id' => 66,
                        'name' => 'YellowGreen',
                        'code' => '#9ACD32',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                66 =>
                    array(
                        'id' => 67,
                        'name' => 'OliveDrab',
                        'code' => '#6B8E23',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                67 =>
                    array(
                        'id' => 68,
                        'name' => 'Olive',
                        'code' => '#808000',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                68 =>
                    array(
                        'id' => 69,
                        'name' => 'DarkOliveGreen',
                        'code' => '#556B2F',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                69 =>
                    array(
                        'id' => 70,
                        'name' => 'MediumAquamarine',
                        'code' => '#66CDAA',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                70 =>
                    array(
                        'id' => 71,
                        'name' => 'DarkSeaGreen',
                        'code' => '#8FBC8F',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                71 =>
                    array(
                        'id' => 72,
                        'name' => 'LightSeaGreen',
                        'code' => '#20B2AA',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                72 =>
                    array(
                        'id' => 73,
                        'name' => 'DarkCyan',
                        'code' => '#008B8B',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                73 =>
                    array(
                        'id' => 74,
                        'name' => 'Teal',
                        'code' => '#008080',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                74 =>
                    array(
                        'id' => 75,
                        'name' => 'Aqua',
                        'code' => '#00FFFF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                75 =>
                    array(
                        'id' => 76,
                        'name' => 'Cyan',
                        'code' => '#00FFFF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                76 =>
                    array(
                        'id' => 77,
                        'name' => 'LightCyan',
                        'code' => '#E0FFFF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                77 =>
                    array(
                        'id' => 78,
                        'name' => 'PaleTurquoise',
                        'code' => '#AFEEEE',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                78 =>
                    array(
                        'id' => 79,
                        'name' => 'Aquamarine',
                        'code' => '#7FFFD4',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                79 =>
                    array(
                        'id' => 80,
                        'name' => 'Turquoise',
                        'code' => '#40E0D0',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                80 =>
                    array(
                        'id' => 81,
                        'name' => 'MediumTurquoise',
                        'code' => '#48D1CC',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                81 =>
                    array(
                        'id' => 82,
                        'name' => 'DarkTurquoise',
                        'code' => '#00CED1',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                82 =>
                    array(
                        'id' => 83,
                        'name' => 'CadetBlue',
                        'code' => '#5F9EA0',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                83 =>
                    array(
                        'id' => 84,
                        'name' => 'SteelBlue',
                        'code' => '#4682B4',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                84 =>
                    array(
                        'id' => 85,
                        'name' => 'LightSteelBlue',
                        'code' => '#B0C4DE',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                85 =>
                    array(
                        'id' => 86,
                        'name' => 'PowderBlue',
                        'code' => '#B0E0E6',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                86 =>
                    array(
                        'id' => 87,
                        'name' => 'LightBlue',
                        'code' => '#ADD8E6',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                87 =>
                    array(
                        'id' => 88,
                        'name' => 'SkyBlue',
                        'code' => '#87CEEB',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                88 =>
                    array(
                        'id' => 89,
                        'name' => 'LightSkyBlue',
                        'code' => '#87CEFA',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                89 =>
                    array(
                        'id' => 90,
                        'name' => 'DeepSkyBlue',
                        'code' => '#00BFFF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                90 =>
                    array(
                        'id' => 91,
                        'name' => 'DodgerBlue',
                        'code' => '#1E90FF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                91 =>
                    array(
                        'id' => 92,
                        'name' => 'CornflowerBlue',
                        'code' => '#6495ED',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                92 =>
                    array(
                        'id' => 93,
                        'name' => 'MediumSlateBlue',
                        'code' => '#7B68EE',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                93 =>
                    array(
                        'id' => 94,
                        'name' => 'RoyalBlue',
                        'code' => '#4169E1',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                94 =>
                    array(
                        'id' => 95,
                        'name' => 'Blue',
                        'code' => '#0000FF',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                95 =>
                    array(
                        'id' => 96,
                        'name' => 'MediumBlue',
                        'code' => '#0000CD',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                96 =>
                    array(
                        'id' => 97,
                        'name' => 'DarkBlue',
                        'code' => '#00008B',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                97 =>
                    array(
                        'id' => 98,
                        'name' => 'Navy',
                        'code' => '#000080',
                        'created_at' => '2018-11-05 04:12:28',
                        'updated_at' => '2018-11-05 04:12:28',
                    ),
                98 =>
                    array(
                        'id' => 99,
                        'name' => 'MidnightBlue',
                        'code' => '#191970',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                99 =>
                    array(
                        'id' => 100,
                        'name' => 'Cornsilk',
                        'code' => '#FFF8DC',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                100 =>
                    array(
                        'id' => 101,
                        'name' => 'BlanchedAlmond',
                        'code' => '#FFEBCD',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                101 =>
                    array(
                        'id' => 102,
                        'name' => 'Bisque',
                        'code' => '#FFE4C4',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                102 =>
                    array(
                        'id' => 103,
                        'name' => 'NavajoWhite',
                        'code' => '#FFDEAD',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                103 =>
                    array(
                        'id' => 104,
                        'name' => 'Wheat',
                        'code' => '#F5DEB3',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                104 =>
                    array(
                        'id' => 105,
                        'name' => 'BurlyWood',
                        'code' => '#DEB887',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                105 =>
                    array(
                        'id' => 106,
                        'name' => 'Tan',
                        'code' => '#D2B48C',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                106 =>
                    array(
                        'id' => 107,
                        'name' => 'RosyBrown',
                        'code' => '#BC8F8F',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                107 =>
                    array(
                        'id' => 108,
                        'name' => 'SandyBrown',
                        'code' => '#F4A460',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                108 =>
                    array(
                        'id' => 109,
                        'name' => 'Goldenrod',
                        'code' => '#DAA520',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                109 =>
                    array(
                        'id' => 110,
                        'name' => 'DarkGoldenrod',
                        'code' => '#B8860B',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                110 =>
                    array(
                        'id' => 111,
                        'name' => 'Peru',
                        'code' => '#CD853F',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                111 =>
                    array(
                        'id' => 112,
                        'name' => 'Chocolate',
                        'code' => '#D2691E',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                112 =>
                    array(
                        'id' => 113,
                        'name' => 'SaddleBrown',
                        'code' => '#8B4513',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                113 =>
                    array(
                        'id' => 114,
                        'name' => 'Sienna',
                        'code' => '#A0522D',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                114 =>
                    array(
                        'id' => 115,
                        'name' => 'Brown',
                        'code' => '#A52A2A',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                115 =>
                    array(
                        'id' => 116,
                        'name' => 'Maroon',
                        'code' => '#800000',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                116 =>
                    array(
                        'id' => 117,
                        'name' => 'White',
                        'code' => '#FFFFFF',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                117 =>
                    array(
                        'id' => 118,
                        'name' => 'Snow',
                        'code' => '#FFFAFA',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                118 =>
                    array(
                        'id' => 119,
                        'name' => 'Honeydew',
                        'code' => '#F0FFF0',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                119 =>
                    array(
                        'id' => 120,
                        'name' => 'MintCream',
                        'code' => '#F5FFFA',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                120 =>
                    array(
                        'id' => 121,
                        'name' => 'Azure',
                        'code' => '#F0FFFF',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                121 =>
                    array(
                        'id' => 122,
                        'name' => 'AliceBlue',
                        'code' => '#F0F8FF',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                122 =>
                    array(
                        'id' => 123,
                        'name' => 'GhostWhite',
                        'code' => '#F8F8FF',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                123 =>
                    array(
                        'id' => 124,
                        'name' => 'WhiteSmoke',
                        'code' => '#F5F5F5',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                124 =>
                    array(
                        'id' => 125,
                        'name' => 'Seashell',
                        'code' => '#FFF5EE',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                125 =>
                    array(
                        'id' => 126,
                        'name' => 'Beige',
                        'code' => '#F5F5DC',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                126 =>
                    array(
                        'id' => 127,
                        'name' => 'OldLace',
                        'code' => '#FDF5E6',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                127 =>
                    array(
                        'id' => 128,
                        'name' => 'FloralWhite',
                        'code' => '#FFFAF0',
                        'created_at' => '2018-11-05 04:12:29',
                        'updated_at' => '2018-11-05 04:12:29',
                    ),
                128 =>
                    array(
                        'id' => 129,
                        'name' => 'Ivory',
                        'code' => '#FFFFF0',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                129 =>
                    array(
                        'id' => 130,
                        'name' => 'AntiqueWhite',
                        'code' => '#FAEBD7',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                130 =>
                    array(
                        'id' => 131,
                        'name' => 'Linen',
                        'code' => '#FAF0E6',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                131 =>
                    array(
                        'id' => 132,
                        'name' => 'LavenderBlush',
                        'code' => '#FFF0F5',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                132 =>
                    array(
                        'id' => 133,
                        'name' => 'MistyRose',
                        'code' => '#FFE4E1',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                133 =>
                    array(
                        'id' => 134,
                        'name' => 'Gainsboro',
                        'code' => '#DCDCDC',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                134 =>
                    array(
                        'id' => 135,
                        'name' => 'LightGrey',
                        'code' => '#D3D3D3',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                135 =>
                    array(
                        'id' => 136,
                        'name' => 'Silver',
                        'code' => '#C0C0C0',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                136 =>
                    array(
                        'id' => 137,
                        'name' => 'DarkGray',
                        'code' => '#A9A9A9',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                137 =>
                    array(
                        'id' => 138,
                        'name' => 'Gray',
                        'code' => '#808080',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                138 =>
                    array(
                        'id' => 139,
                        'name' => 'DimGray',
                        'code' => '#696969',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                139 =>
                    array(
                        'id' => 140,
                        'name' => 'LightSlateGray',
                        'code' => '#778899',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                140 =>
                    array(
                        'id' => 141,
                        'name' => 'SlateGray',
                        'code' => '#708090',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                141 =>
                    array(
                        'id' => 142,
                        'name' => 'DarkSlateGray',
                        'code' => '#2F4F4F',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
                142 =>
                    array(
                        'id' => 143,
                        'name' => 'Black',
                        'code' => '#000000',
                        'created_at' => '2018-11-05 04:12:30',
                        'updated_at' => '2018-11-05 04:12:30',
                    ),
            ));
        }

    }
}

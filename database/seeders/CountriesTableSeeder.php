<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('countries')->count() == 0) {
            \DB::table('countries')->delete();

            \DB::table('countries')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'code' => 'AF',
                        'name' => 'Afghanistan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'code' => 'AL',
                        'name' => 'Albania',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'code' => 'DZ',
                        'name' => 'Algeria',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'code' => 'DS',
                        'name' => 'American Samoa',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'code' => 'AD',
                        'name' => 'Andorra',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'code' => 'AO',
                        'name' => 'Angola',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'code' => 'AI',
                        'name' => 'Anguilla',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'code' => 'AQ',
                        'name' => 'Antarctica',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'code' => 'AG',
                        'name' => 'Antigua and Barbuda',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'code' => 'AR',
                        'name' => 'Argentina',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'code' => 'AM',
                        'name' => 'Armenia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'code' => 'AW',
                        'name' => 'Aruba',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'code' => 'AU',
                        'name' => 'Australia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'code' => 'AT',
                        'name' => 'Austria',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'code' => 'AZ',
                        'name' => 'Azerbaijan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'code' => 'BS',
                        'name' => 'Bahamas',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'code' => 'BH',
                        'name' => 'Bahrain',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'code' => 'BD',
                        'name' => 'Bangladesh',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'code' => 'BB',
                        'name' => 'Barbados',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'code' => 'BY',
                        'name' => 'Belarus',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'code' => 'BE',
                        'name' => 'Belgium',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                21 =>
                    array(
                        'id' => 22,
                        'code' => 'BZ',
                        'name' => 'Belize',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                22 =>
                    array(
                        'id' => 23,
                        'code' => 'BJ',
                        'name' => 'Benin',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                23 =>
                    array(
                        'id' => 24,
                        'code' => 'BM',
                        'name' => 'Bermuda',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                24 =>
                    array(
                        'id' => 25,
                        'code' => 'BT',
                        'name' => 'Bhutan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                25 =>
                    array(
                        'id' => 26,
                        'code' => 'BO',
                        'name' => 'Bolivia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                26 =>
                    array(
                        'id' => 27,
                        'code' => 'BA',
                        'name' => 'Bosnia and Herzegovina',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                27 =>
                    array(
                        'id' => 28,
                        'code' => 'BW',
                        'name' => 'Botswana',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                28 =>
                    array(
                        'id' => 29,
                        'code' => 'BV',
                        'name' => 'Bouvet Island',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                29 =>
                    array(
                        'id' => 30,
                        'code' => 'BR',
                        'name' => 'Brazil',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                30 =>
                    array(
                        'id' => 31,
                        'code' => 'IO',
                        'name' => 'British Indian Ocean Territory',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                31 =>
                    array(
                        'id' => 32,
                        'code' => 'BN',
                        'name' => 'Brunei Darussalam',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                32 =>
                    array(
                        'id' => 33,
                        'code' => 'BG',
                        'name' => 'Bulgaria',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                33 =>
                    array(
                        'id' => 34,
                        'code' => 'BF',
                        'name' => 'Burkina Faso',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                34 =>
                    array(
                        'id' => 35,
                        'code' => 'BI',
                        'name' => 'Burundi',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                35 =>
                    array(
                        'id' => 36,
                        'code' => 'KH',
                        'name' => 'Cambodia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                36 =>
                    array(
                        'id' => 37,
                        'code' => 'CM',
                        'name' => 'Cameroon',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                37 =>
                    array(
                        'id' => 38,
                        'code' => 'CA',
                        'name' => 'Canada',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                38 =>
                    array(
                        'id' => 39,
                        'code' => 'CV',
                        'name' => 'Cape Verde',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                39 =>
                    array(
                        'id' => 40,
                        'code' => 'KY',
                        'name' => 'Cayman Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                40 =>
                    array(
                        'id' => 41,
                        'code' => 'CF',
                        'name' => 'Central African Republic',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                41 =>
                    array(
                        'id' => 42,
                        'code' => 'TD',
                        'name' => 'Chad',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                42 =>
                    array(
                        'id' => 43,
                        'code' => 'CL',
                        'name' => 'Chile',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                43 =>
                    array(
                        'id' => 44,
                        'code' => 'CN',
                        'name' => 'China',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                44 =>
                    array(
                        'id' => 45,
                        'code' => 'CX',
                        'name' => 'Christmas Island',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                45 =>
                    array(
                        'id' => 46,
                        'code' => 'CC',
                        'name' => 'Cocos (Keeling) Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                46 =>
                    array(
                        'id' => 47,
                        'code' => 'CO',
                        'name' => 'Colombia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                47 =>
                    array(
                        'id' => 48,
                        'code' => 'KM',
                        'name' => 'Comoros',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                48 =>
                    array(
                        'id' => 49,
                        'code' => 'CG',
                        'name' => 'Congo',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                49 =>
                    array(
                        'id' => 50,
                        'code' => 'CK',
                        'name' => 'Cook Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                50 =>
                    array(
                        'id' => 51,
                        'code' => 'CR',
                        'name' => 'Costa Rica',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                51 =>
                    array(
                        'id' => 52,
                        'code' => 'HR',
                        'name' => 'Croatia (Hrvatska)',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                52 =>
                    array(
                        'id' => 53,
                        'code' => 'CU',
                        'name' => 'Cuba',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                53 =>
                    array(
                        'id' => 54,
                        'code' => 'CY',
                        'name' => 'Cyprus',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                54 =>
                    array(
                        'id' => 55,
                        'code' => 'CZ',
                        'name' => 'Czech Republic',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                55 =>
                    array(
                        'id' => 56,
                        'code' => 'DK',
                        'name' => 'Denmark',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                56 =>
                    array(
                        'id' => 57,
                        'code' => 'DJ',
                        'name' => 'Djibouti',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                57 =>
                    array(
                        'id' => 58,
                        'code' => 'DM',
                        'name' => 'Dominica',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                58 =>
                    array(
                        'id' => 59,
                        'code' => 'DO',
                        'name' => 'Dominican Republic',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                59 =>
                    array(
                        'id' => 60,
                        'code' => 'TP',
                        'name' => 'East Timor',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                60 =>
                    array(
                        'id' => 61,
                        'code' => 'EC',
                        'name' => 'Ecuador',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                61 =>
                    array(
                        'id' => 62,
                        'code' => 'EG',
                        'name' => 'Egypt',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                62 =>
                    array(
                        'id' => 63,
                        'code' => 'SV',
                        'name' => 'El Salvador',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                63 =>
                    array(
                        'id' => 64,
                        'code' => 'GQ',
                        'name' => 'Equatorial Guinea',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                64 =>
                    array(
                        'id' => 65,
                        'code' => 'ER',
                        'name' => 'Eritrea',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                65 =>
                    array(
                        'id' => 66,
                        'code' => 'EE',
                        'name' => 'Estonia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                66 =>
                    array(
                        'id' => 67,
                        'code' => 'ET',
                        'name' => 'Ethiopia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                67 =>
                    array(
                        'id' => 68,
                        'code' => 'FK',
                        'name' => 'Falkland Islands (Malvinas)',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                68 =>
                    array(
                        'id' => 69,
                        'code' => 'FO',
                        'name' => 'Faroe Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                69 =>
                    array(
                        'id' => 70,
                        'code' => 'FJ',
                        'name' => 'Fiji',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                70 =>
                    array(
                        'id' => 71,
                        'code' => 'FI',
                        'name' => 'Finland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                71 =>
                    array(
                        'id' => 72,
                        'code' => 'FR',
                        'name' => 'France',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                72 =>
                    array(
                        'id' => 73,
                        'code' => 'FX',
                        'name' => 'France, Metropolitan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                73 =>
                    array(
                        'id' => 74,
                        'code' => 'GF',
                        'name' => 'French Guiana',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                74 =>
                    array(
                        'id' => 75,
                        'code' => 'PF',
                        'name' => 'French Polynesia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                75 =>
                    array(
                        'id' => 76,
                        'code' => 'TF',
                        'name' => 'French Southern Territories',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                76 =>
                    array(
                        'id' => 77,
                        'code' => 'GA',
                        'name' => 'Gabon',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                77 =>
                    array(
                        'id' => 78,
                        'code' => 'GM',
                        'name' => 'Gambia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                78 =>
                    array(
                        'id' => 79,
                        'code' => 'GE',
                        'name' => 'Georgia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                79 =>
                    array(
                        'id' => 80,
                        'code' => 'DE',
                        'name' => 'Germany',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                80 =>
                    array(
                        'id' => 81,
                        'code' => 'GH',
                        'name' => 'Ghana',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                81 =>
                    array(
                        'id' => 82,
                        'code' => 'GI',
                        'name' => 'Gibraltar',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                82 =>
                    array(
                        'id' => 83,
                        'code' => 'GK',
                        'name' => 'Guernsey',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                83 =>
                    array(
                        'id' => 84,
                        'code' => 'GR',
                        'name' => 'Greece',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                84 =>
                    array(
                        'id' => 85,
                        'code' => 'GL',
                        'name' => 'Greenland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                85 =>
                    array(
                        'id' => 86,
                        'code' => 'GD',
                        'name' => 'Grenada',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                86 =>
                    array(
                        'id' => 87,
                        'code' => 'GP',
                        'name' => 'Guadeloupe',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                87 =>
                    array(
                        'id' => 88,
                        'code' => 'GU',
                        'name' => 'Guam',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                88 =>
                    array(
                        'id' => 89,
                        'code' => 'GT',
                        'name' => 'Guatemala',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                89 =>
                    array(
                        'id' => 90,
                        'code' => 'GN',
                        'name' => 'Guinea',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                90 =>
                    array(
                        'id' => 91,
                        'code' => 'GW',
                        'name' => 'Guinea-Bissau',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                91 =>
                    array(
                        'id' => 92,
                        'code' => 'GY',
                        'name' => 'Guyana',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                92 =>
                    array(
                        'id' => 93,
                        'code' => 'HT',
                        'name' => 'Haiti',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                93 =>
                    array(
                        'id' => 94,
                        'code' => 'HM',
                        'name' => 'Heard and Mc Donald Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                94 =>
                    array(
                        'id' => 95,
                        'code' => 'HN',
                        'name' => 'Honduras',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                95 =>
                    array(
                        'id' => 96,
                        'code' => 'HK',
                        'name' => 'Hong Kong',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                96 =>
                    array(
                        'id' => 97,
                        'code' => 'HU',
                        'name' => 'Hungary',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                97 =>
                    array(
                        'id' => 98,
                        'code' => 'IS',
                        'name' => 'Iceland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                98 =>
                    array(
                        'id' => 99,
                        'code' => 'IN',
                        'name' => 'India',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                99 =>
                    array(
                        'id' => 100,
                        'code' => 'IM',
                        'name' => 'Isle of Man',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                100 =>
                    array(
                        'id' => 101,
                        'code' => 'ID',
                        'name' => 'Indonesia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                101 =>
                    array(
                        'id' => 102,
                        'code' => 'IR',
                        'name' => 'Iran (Islamic Republic of)',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                102 =>
                    array(
                        'id' => 103,
                        'code' => 'IQ',
                        'name' => 'Iraq',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                103 =>
                    array(
                        'id' => 104,
                        'code' => 'IE',
                        'name' => 'Ireland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                104 =>
                    array(
                        'id' => 105,
                        'code' => 'IL',
                        'name' => 'Israel',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                105 =>
                    array(
                        'id' => 106,
                        'code' => 'IT',
                        'name' => 'Italy',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                106 =>
                    array(
                        'id' => 107,
                        'code' => 'CI',
                        'name' => 'Ivory Coast',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                107 =>
                    array(
                        'id' => 108,
                        'code' => 'JE',
                        'name' => 'Jersey',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                108 =>
                    array(
                        'id' => 109,
                        'code' => 'JM',
                        'name' => 'Jamaica',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                109 =>
                    array(
                        'id' => 110,
                        'code' => 'JP',
                        'name' => 'Japan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                110 =>
                    array(
                        'id' => 111,
                        'code' => 'JO',
                        'name' => 'Jordan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                111 =>
                    array(
                        'id' => 112,
                        'code' => 'KZ',
                        'name' => 'Kazakhstan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                112 =>
                    array(
                        'id' => 113,
                        'code' => 'KE',
                        'name' => 'Kenya',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                113 =>
                    array(
                        'id' => 114,
                        'code' => 'KI',
                        'name' => 'Kiribati',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                114 =>
                    array(
                        'id' => 115,
                        'code' => 'KP',
                        'name' => 'Korea, Democratic People\'s Republic of',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                115 =>
                    array(
                        'id' => 116,
                        'code' => 'KR',
                        'name' => 'Korea, Republic of',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                116 =>
                    array(
                        'id' => 117,
                        'code' => 'XK',
                        'name' => 'Kosovo',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                117 =>
                    array(
                        'id' => 118,
                        'code' => 'KW',
                        'name' => 'Kuwait',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                118 =>
                    array(
                        'id' => 119,
                        'code' => 'KG',
                        'name' => 'Kyrgyzstan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                119 =>
                    array(
                        'id' => 120,
                        'code' => 'LA',
                        'name' => 'Lao People\'s Democratic Republic',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                120 =>
                    array(
                        'id' => 121,
                        'code' => 'LV',
                        'name' => 'Latvia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                121 =>
                    array(
                        'id' => 122,
                        'code' => 'LB',
                        'name' => 'Lebanon',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                122 =>
                    array(
                        'id' => 123,
                        'code' => 'LS',
                        'name' => 'Lesotho',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                123 =>
                    array(
                        'id' => 124,
                        'code' => 'LR',
                        'name' => 'Liberia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                124 =>
                    array(
                        'id' => 125,
                        'code' => 'LY',
                        'name' => 'Libyan Arab Jamahiriya',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                125 =>
                    array(
                        'id' => 126,
                        'code' => 'LI',
                        'name' => 'Liechtenstein',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                126 =>
                    array(
                        'id' => 127,
                        'code' => 'LT',
                        'name' => 'Lithuania',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                127 =>
                    array(
                        'id' => 128,
                        'code' => 'LU',
                        'name' => 'Luxembourg',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                128 =>
                    array(
                        'id' => 129,
                        'code' => 'MO',
                        'name' => 'Macau',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                129 =>
                    array(
                        'id' => 130,
                        'code' => 'MK',
                        'name' => 'Macedonia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                130 =>
                    array(
                        'id' => 131,
                        'code' => 'MG',
                        'name' => 'Madagascar',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                131 =>
                    array(
                        'id' => 132,
                        'code' => 'MW',
                        'name' => 'Malawi',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                132 =>
                    array(
                        'id' => 133,
                        'code' => 'MY',
                        'name' => 'Malaysia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                133 =>
                    array(
                        'id' => 134,
                        'code' => 'MV',
                        'name' => 'Maldives',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                134 =>
                    array(
                        'id' => 135,
                        'code' => 'ML',
                        'name' => 'Mali',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                135 =>
                    array(
                        'id' => 136,
                        'code' => 'MT',
                        'name' => 'Malta',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                136 =>
                    array(
                        'id' => 137,
                        'code' => 'MH',
                        'name' => 'Marshall Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                137 =>
                    array(
                        'id' => 138,
                        'code' => 'MQ',
                        'name' => 'Martinique',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                138 =>
                    array(
                        'id' => 139,
                        'code' => 'MR',
                        'name' => 'Mauritania',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                139 =>
                    array(
                        'id' => 140,
                        'code' => 'MU',
                        'name' => 'Mauritius',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                140 =>
                    array(
                        'id' => 141,
                        'code' => 'TY',
                        'name' => 'Mayotte',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                141 =>
                    array(
                        'id' => 142,
                        'code' => 'MX',
                        'name' => 'Mexico',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                142 =>
                    array(
                        'id' => 143,
                        'code' => 'FM',
                        'name' => 'Micronesia, Federated States of',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                143 =>
                    array(
                        'id' => 144,
                        'code' => 'MD',
                        'name' => 'Moldova, Republic of',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                144 =>
                    array(
                        'id' => 145,
                        'code' => 'MC',
                        'name' => 'Monaco',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                145 =>
                    array(
                        'id' => 146,
                        'code' => 'MN',
                        'name' => 'Mongolia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                146 =>
                    array(
                        'id' => 147,
                        'code' => 'ME',
                        'name' => 'Montenegro',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                147 =>
                    array(
                        'id' => 148,
                        'code' => 'MS',
                        'name' => 'Montserrat',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                148 =>
                    array(
                        'id' => 149,
                        'code' => 'MA',
                        'name' => 'Morocco',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                149 =>
                    array(
                        'id' => 150,
                        'code' => 'MZ',
                        'name' => 'Mozambique',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                150 =>
                    array(
                        'id' => 151,
                        'code' => 'MM',
                        'name' => 'Myanmar',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                151 =>
                    array(
                        'id' => 152,
                        'code' => 'NA',
                        'name' => 'Namibia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                152 =>
                    array(
                        'id' => 153,
                        'code' => 'NR',
                        'name' => 'Nauru',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                153 =>
                    array(
                        'id' => 154,
                        'code' => 'NP',
                        'name' => 'Nepal',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                154 =>
                    array(
                        'id' => 155,
                        'code' => 'NL',
                        'name' => 'Netherlands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                155 =>
                    array(
                        'id' => 156,
                        'code' => 'AN',
                        'name' => 'Netherlands Antilles',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                156 =>
                    array(
                        'id' => 157,
                        'code' => 'NC',
                        'name' => 'New Caledonia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                157 =>
                    array(
                        'id' => 158,
                        'code' => 'NZ',
                        'name' => 'New Zealand',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                158 =>
                    array(
                        'id' => 159,
                        'code' => 'NI',
                        'name' => 'Nicaragua',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                159 =>
                    array(
                        'id' => 160,
                        'code' => 'NE',
                        'name' => 'Niger',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                160 =>
                    array(
                        'id' => 161,
                        'code' => 'NG',
                        'name' => 'Nigeria',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                161 =>
                    array(
                        'id' => 162,
                        'code' => 'NU',
                        'name' => 'Niue',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                162 =>
                    array(
                        'id' => 163,
                        'code' => 'NF',
                        'name' => 'Norfolk Island',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                163 =>
                    array(
                        'id' => 164,
                        'code' => 'MP',
                        'name' => 'Northern Mariana Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                164 =>
                    array(
                        'id' => 165,
                        'code' => 'NO',
                        'name' => 'Norway',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                165 =>
                    array(
                        'id' => 166,
                        'code' => 'OM',
                        'name' => 'Oman',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                166 =>
                    array(
                        'id' => 167,
                        'code' => 'PK',
                        'name' => 'Pakistan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                167 =>
                    array(
                        'id' => 168,
                        'code' => 'PW',
                        'name' => 'Palau',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                168 =>
                    array(
                        'id' => 169,
                        'code' => 'PS',
                        'name' => 'Palestine',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                169 =>
                    array(
                        'id' => 170,
                        'code' => 'PA',
                        'name' => 'Panama',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                170 =>
                    array(
                        'id' => 171,
                        'code' => 'PG',
                        'name' => 'Papua New Guinea',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                171 =>
                    array(
                        'id' => 172,
                        'code' => 'PY',
                        'name' => 'Paraguay',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                172 =>
                    array(
                        'id' => 173,
                        'code' => 'PE',
                        'name' => 'Peru',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                173 =>
                    array(
                        'id' => 174,
                        'code' => 'PH',
                        'name' => 'Philippines',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                174 =>
                    array(
                        'id' => 175,
                        'code' => 'PN',
                        'name' => 'Pitcairn',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                175 =>
                    array(
                        'id' => 176,
                        'code' => 'PL',
                        'name' => 'Poland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                176 =>
                    array(
                        'id' => 177,
                        'code' => 'PT',
                        'name' => 'Portugal',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                177 =>
                    array(
                        'id' => 178,
                        'code' => 'PR',
                        'name' => 'Puerto Rico',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                178 =>
                    array(
                        'id' => 179,
                        'code' => 'QA',
                        'name' => 'Qatar',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                179 =>
                    array(
                        'id' => 180,
                        'code' => 'RE',
                        'name' => 'Reunion',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                180 =>
                    array(
                        'id' => 181,
                        'code' => 'RO',
                        'name' => 'Romania',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                181 =>
                    array(
                        'id' => 182,
                        'code' => 'RU',
                        'name' => 'Russian Federation',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                182 =>
                    array(
                        'id' => 183,
                        'code' => 'RW',
                        'name' => 'Rwanda',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                183 =>
                    array(
                        'id' => 184,
                        'code' => 'KN',
                        'name' => 'Saint Kitts and Nevis',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                184 =>
                    array(
                        'id' => 185,
                        'code' => 'LC',
                        'name' => 'Saint Lucia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                185 =>
                    array(
                        'id' => 186,
                        'code' => 'VC',
                        'name' => 'Saint Vincent and the Grenadines',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                186 =>
                    array(
                        'id' => 187,
                        'code' => 'WS',
                        'name' => 'Samoa',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                187 =>
                    array(
                        'id' => 188,
                        'code' => 'SM',
                        'name' => 'San Marino',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                188 =>
                    array(
                        'id' => 189,
                        'code' => 'ST',
                        'name' => 'Sao Tome and Principe',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                189 =>
                    array(
                        'id' => 190,
                        'code' => 'SA',
                        'name' => 'Saudi Arabia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                190 =>
                    array(
                        'id' => 191,
                        'code' => 'SN',
                        'name' => 'Senegal',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                191 =>
                    array(
                        'id' => 192,
                        'code' => 'RS',
                        'name' => 'Serbia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                192 =>
                    array(
                        'id' => 193,
                        'code' => 'SC',
                        'name' => 'Seychelles',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                193 =>
                    array(
                        'id' => 194,
                        'code' => 'SL',
                        'name' => 'Sierra Leone',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                194 =>
                    array(
                        'id' => 195,
                        'code' => 'SG',
                        'name' => 'Singapore',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                195 =>
                    array(
                        'id' => 196,
                        'code' => 'SK',
                        'name' => 'Slovakia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                196 =>
                    array(
                        'id' => 197,
                        'code' => 'SI',
                        'name' => 'Slovenia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                197 =>
                    array(
                        'id' => 198,
                        'code' => 'SB',
                        'name' => 'Solomon Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                198 =>
                    array(
                        'id' => 199,
                        'code' => 'SO',
                        'name' => 'Somalia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                199 =>
                    array(
                        'id' => 200,
                        'code' => 'ZA',
                        'name' => 'South Africa',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                200 =>
                    array(
                        'id' => 201,
                        'code' => 'GS',
                        'name' => 'South Georgia South Sandwich Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                201 =>
                    array(
                        'id' => 202,
                        'code' => 'SS',
                        'name' => 'South Sudan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                202 =>
                    array(
                        'id' => 203,
                        'code' => 'ES',
                        'name' => 'Spain',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                203 =>
                    array(
                        'id' => 204,
                        'code' => 'LK',
                        'name' => 'Sri Lanka',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                204 =>
                    array(
                        'id' => 205,
                        'code' => 'SH',
                        'name' => 'St. Helena',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                205 =>
                    array(
                        'id' => 206,
                        'code' => 'PM',
                        'name' => 'St. Pierre and Miquelon',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                206 =>
                    array(
                        'id' => 207,
                        'code' => 'SD',
                        'name' => 'Sudan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                207 =>
                    array(
                        'id' => 208,
                        'code' => 'SR',
                        'name' => 'Suriname',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                208 =>
                    array(
                        'id' => 209,
                        'code' => 'SJ',
                        'name' => 'Svalbard and Jan Mayen Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                209 =>
                    array(
                        'id' => 210,
                        'code' => 'SZ',
                        'name' => 'Swaziland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                210 =>
                    array(
                        'id' => 211,
                        'code' => 'SE',
                        'name' => 'Sweden',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                211 =>
                    array(
                        'id' => 212,
                        'code' => 'CH',
                        'name' => 'Switzerland',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                212 =>
                    array(
                        'id' => 213,
                        'code' => 'SY',
                        'name' => 'Syrian Arab Republic',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                213 =>
                    array(
                        'id' => 214,
                        'code' => 'TW',
                        'name' => 'Taiwan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                214 =>
                    array(
                        'id' => 215,
                        'code' => 'TJ',
                        'name' => 'Tajikistan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                215 =>
                    array(
                        'id' => 216,
                        'code' => 'TZ',
                        'name' => 'Tanzania, United Republic of',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                216 =>
                    array(
                        'id' => 217,
                        'code' => 'TH',
                        'name' => 'Thailand',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                217 =>
                    array(
                        'id' => 218,
                        'code' => 'TG',
                        'name' => 'Togo',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                218 =>
                    array(
                        'id' => 219,
                        'code' => 'TK',
                        'name' => 'Tokelau',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                219 =>
                    array(
                        'id' => 220,
                        'code' => 'TO',
                        'name' => 'Tonga',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                220 =>
                    array(
                        'id' => 221,
                        'code' => 'TT',
                        'name' => 'Trinidad and Tobago',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                221 =>
                    array(
                        'id' => 222,
                        'code' => 'TN',
                        'name' => 'Tunisia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                222 =>
                    array(
                        'id' => 223,
                        'code' => 'TR',
                        'name' => 'Turkey',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                223 =>
                    array(
                        'id' => 224,
                        'code' => 'TM',
                        'name' => 'Turkmenistan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                224 =>
                    array(
                        'id' => 225,
                        'code' => 'TC',
                        'name' => 'Turks and Caicos Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                225 =>
                    array(
                        'id' => 226,
                        'code' => 'TV',
                        'name' => 'Tuvalu',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                226 =>
                    array(
                        'id' => 227,
                        'code' => 'UG',
                        'name' => 'Uganda',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                227 =>
                    array(
                        'id' => 228,
                        'code' => 'UA',
                        'name' => 'Ukraine',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                228 =>
                    array(
                        'id' => 229,
                        'code' => 'AE',
                        'name' => 'United Arab Emirates',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                229 =>
                    array(
                        'id' => 230,
                        'code' => 'GB',
                        'name' => 'United Kingdom',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                230 =>
                    array(
                        'id' => 231,
                        'code' => 'US',
                        'name' => 'United States',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                231 =>
                    array(
                        'id' => 232,
                        'code' => 'UM',
                        'name' => 'United States minor outlying islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                232 =>
                    array(
                        'id' => 233,
                        'code' => 'UY',
                        'name' => 'Uruguay',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                233 =>
                    array(
                        'id' => 234,
                        'code' => 'UZ',
                        'name' => 'Uzbekistan',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                234 =>
                    array(
                        'id' => 235,
                        'code' => 'VU',
                        'name' => 'Vanuatu',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                235 =>
                    array(
                        'id' => 236,
                        'code' => 'VA',
                        'name' => 'Vatican City State',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                236 =>
                    array(
                        'id' => 237,
                        'code' => 'VE',
                        'name' => 'Venezuela',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                237 =>
                    array(
                        'id' => 238,
                        'code' => 'VN',
                        'name' => 'Vietnam',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                238 =>
                    array(
                        'id' => 239,
                        'code' => 'VG',
                        'name' => 'Virgin Islands (British)',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                239 =>
                    array(
                        'id' => 240,
                        'code' => 'VI',
                        'name' => 'Virgin Islands (U.S.)',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                240 =>
                    array(
                        'id' => 241,
                        'code' => 'WF',
                        'name' => 'Wallis and Futuna Islands',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                241 =>
                    array(
                        'id' => 242,
                        'code' => 'EH',
                        'name' => 'Western Sahara',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                242 =>
                    array(
                        'id' => 243,
                        'code' => 'YE',
                        'name' => 'Yemen',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                243 =>
                    array(
                        'id' => 244,
                        'code' => 'ZR',
                        'name' => 'Zaire',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                244 =>
                    array(
                        'id' => 245,
                        'code' => 'ZM',
                        'name' => 'Zambia',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
                245 =>
                    array(
                        'id' => 246,
                        'code' => 'ZW',
                        'name' => 'Zimbabwe',
                        'status' => 1,
                        'created_at' => NULL,
                        'updated_at' => NULL,
                    ),
            ));

        }
    }
}

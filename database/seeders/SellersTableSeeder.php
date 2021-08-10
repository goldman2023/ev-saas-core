<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SellersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('sellers')->count() == 0) {

            \DB::table('sellers')->delete();

            \DB::table('sellers')->insert(array(
                0 =>
                    array(
                        'id' => 1,
                        'user_id' => 2,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Mr. Seller"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 78.4,
                        'bank_name' => NULL,
                        'bank_acc_name' => NULL,
                        'bank_acc_no' => NULL,
                        'bank_routing_no' => NULL,
                        'bank_payment_status' => 0,
                    ),
                1 =>
                    array(
                        'id' => 2,
                        'user_id' => 4,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 1"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 79.4,
                        'bank_name' => 'Seller Bank 1',
                        'bank_acc_name' => 'seller-bank-1',
                        'bank_acc_no' => 1,
                        'bank_routing_no' => 1,
                        'bank_payment_status' => 0,
                    ),
                2 =>
                    array(
                        'id' => 3,
                        'user_id' => 5,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 2"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 75.8,
                        'bank_name' => 'Seller Bank 2',
                        'bank_acc_name' => 'seller-bank-2',
                        'bank_acc_no' => 2,
                        'bank_routing_no' => 2,
                        'bank_payment_status' => 0,
                    ),
                3 =>
                    array(
                        'id' => 4,
                        'user_id' => 6,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 3"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 80.0,
                        'bank_name' => 'Seller Bank 3',
                        'bank_acc_name' => 'seller-bank-3',
                        'bank_acc_no' => 3,
                        'bank_routing_no' => 3,
                        'bank_payment_status' => 0,
                    ),
                4 =>
                    array(
                        'id' => 5,
                        'user_id' => 7,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 4"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 84.2,
                        'bank_name' => 'Seller Bank 4',
                        'bank_acc_name' => 'seller-bank-4',
                        'bank_acc_no' => 4,
                        'bank_routing_no' => 4,
                        'bank_payment_status' => 0,
                    ),
                5 =>
                    array(
                        'id' => 6,
                        'user_id' => 8,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 5"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 71.4,
                        'bank_name' => 'Seller Bank 5',
                        'bank_acc_name' => 'seller-bank-5',
                        'bank_acc_no' => 5,
                        'bank_routing_no' => 5,
                        'bank_payment_status' => 0,
                    ),
                6 =>
                    array(
                        'id' => 7,
                        'user_id' => 9,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 6"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 71.5,
                        'bank_name' => 'Seller Bank 6',
                        'bank_acc_name' => 'seller-bank-6',
                        'bank_acc_no' => 6,
                        'bank_routing_no' => 6,
                        'bank_payment_status' => 0,
                    ),
                7 =>
                    array(
                        'id' => 8,
                        'user_id' => 10,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 7"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 71.4,
                        'bank_name' => 'Seller Bank 7',
                        'bank_acc_name' => 'seller-bank-7',
                        'bank_acc_no' => 7,
                        'bank_routing_no' => 7,
                        'bank_payment_status' => 0,
                    ),
                8 =>
                    array(
                        'id' => 9,
                        'user_id' => 11,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 8"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 80.8,
                        'bank_name' => 'Seller Bank 8',
                        'bank_acc_name' => 'seller-bank-8',
                        'bank_acc_no' => 8,
                        'bank_routing_no' => 8,
                        'bank_payment_status' => 0,
                    ),
                9 =>
                    array(
                        'id' => 10,
                        'user_id' => 12,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 9"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 69.8,
                        'bank_name' => 'Seller Bank 9',
                        'bank_acc_name' => 'seller-bank-9',
                        'bank_acc_no' => 9,
                        'bank_routing_no' => 9,
                        'bank_payment_status' => 0,
                    ),
                10 =>
                    array(
                        'id' => 11,
                        'user_id' => 13,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 10"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 74.8,
                        'bank_name' => 'Seller Bank 10',
                        'bank_acc_name' => 'seller-bank-10',
                        'bank_acc_no' => 10,
                        'bank_routing_no' => 10,
                        'bank_payment_status' => 0,
                    ),
                11 =>
                    array(
                        'id' => 12,
                        'user_id' => 14,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 11"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 71.4,
                        'bank_name' => 'Seller Bank 11',
                        'bank_acc_name' => 'seller-bank-11',
                        'bank_acc_no' => 11,
                        'bank_routing_no' => 11,
                        'bank_payment_status' => 0,
                    ),
                12 =>
                    array(
                        'id' => 13,
                        'user_id' => 15,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 12"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 77.7,
                        'bank_name' => 'Seller Bank 12',
                        'bank_acc_name' => 'seller-bank-12',
                        'bank_acc_no' => 12,
                        'bank_routing_no' => 12,
                        'bank_payment_status' => 0,
                    ),
                13 =>
                    array(
                        'id' => 14,
                        'user_id' => 16,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 13"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 73.5,
                        'bank_name' => 'Seller Bank 13',
                        'bank_acc_name' => 'seller-bank-13',
                        'bank_acc_no' => 13,
                        'bank_routing_no' => 13,
                        'bank_payment_status' => 0,
                    ),
                14 =>
                    array(
                        'id' => 15,
                        'user_id' => 17,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 14"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 75.0,
                        'bank_name' => 'Seller Bank 14',
                        'bank_acc_name' => 'seller-bank-14',
                        'bank_acc_no' => 14,
                        'bank_routing_no' => 14,
                        'bank_payment_status' => 0,
                    ),
                15 =>
                    array(
                        'id' => 16,
                        'user_id' => 18,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 15"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 76.5,
                        'bank_name' => 'Seller Bank 15',
                        'bank_acc_name' => 'seller-bank-15',
                        'bank_acc_no' => 15,
                        'bank_routing_no' => 15,
                        'bank_payment_status' => 0,
                    ),
                16 =>
                    array(
                        'id' => 17,
                        'user_id' => 19,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 16"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 77.5,
                        'bank_name' => 'Seller Bank 16',
                        'bank_acc_name' => 'seller-bank-16',
                        'bank_acc_no' => 16,
                        'bank_routing_no' => 16,
                        'bank_payment_status' => 0,
                    ),
                17 =>
                    array(
                        'id' => 18,
                        'user_id' => 20,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 17"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 78.6,
                        'bank_name' => 'Seller Bank 17',
                        'bank_acc_name' => 'seller-bank-17',
                        'bank_acc_no' => 17,
                        'bank_routing_no' => 17,
                        'bank_payment_status' => 0,
                    ),
                18 =>
                    array(
                        'id' => 19,
                        'user_id' => 21,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 18"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 79.8,
                        'bank_name' => 'Seller Bank 18',
                        'bank_acc_name' => 'seller-bank-18',
                        'bank_acc_no' => 18,
                        'bank_routing_no' => 18,
                        'bank_payment_status' => 0,
                    ),
                19 =>
                    array(
                        'id' => 20,
                        'user_id' => 22,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 19"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 80.5,
                        'bank_name' => 'Seller Bank 19',
                        'bank_acc_name' => 'seller-bank-19',
                        'bank_acc_no' => 19,
                        'bank_routing_no' => 19,
                        'bank_payment_status' => 0,
                    ),
                20 =>
                    array(
                        'id' => 21,
                        'user_id' => 23,
                        'verification_status' => 1,
                        'verification_info' => '[{"type":"text","label":"Name","value":"Seller Example 20"},{"type":"select","label":"Marital Status","value":"Married"},{"type":"multi_select","label":"Company","value":"[\\"Company\\"]"},{"type":"select","label":"Gender","value":"Male"},{"type":"file","label":"Image","value":"uploads\\/verification_form\\/CRWqFifcbKqibNzllBhEyUSkV6m1viknGXMEhtiW.png"}]',
                        'cash_on_delivery_status' => 1,
                        'admin_to_pay' => 82.0,
                        'bank_name' => 'Seller Bank 20',
                        'bank_acc_name' => 'seller-bank-20',
                        'bank_acc_no' => 20,
                        'bank_routing_no' => 20,
                        'bank_payment_status' => 0,
                    ),
            ));
        }

    }
}

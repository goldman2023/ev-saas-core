<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UniversalPaymentMethodsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

        if (\DB::table('payment_methods_universal')->count() == 0) {
            \DB::table('payment_methods_universal')->delete();

            \DB::table('payment_methods_universal')->insert([
                [
                    'name' => 'Wire Transfer',
                    'gateway' => 'wire_transfer',
                    'description' => '',
                    'instructions' => '',
                    'data' => '',
                    'enabled' => 0
                ],
                [
                    'name' => 'Paypal',
                    'gateway' => 'paypal',
                    'description' => '',
                    'instructions' => '',
                    'data' => '',
                    'enabled' => 0
                ],
                [
                    'name' => 'Stripe',
                    'gateway' => 'stripe',
                    'description' => '',
                    'instructions' => '',
                    'data' => '',
                    'enabled' => 0
                ],
                [
                    'name' => 'Paysera',
                    'gateway' => 'paysera',
                    'description' => '',
                    'instructions' => '',
                    'data' => '',
                    'enabled' => 0
                ],
            ]);
        }

    }
}

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
                    'permissions' => 'wire_transfer',
                ],
                [
                    'name' => 'Paypal',
                    'permissions' => 'paypal',
                ],
                [
                    'name' => 'Stripe',
                    'permissions' => 'stripe',
                ],
                [
                    'name' => 'Paysera',
                    'permissions' => 'paysera',
                ],
            ]);
        }

    }
}

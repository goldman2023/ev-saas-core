<?php

namespace Database\Seeders;

use App\Models\PaymentMethodUniversal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        if (\DB::table('payment_methods_universal')->count() == 0) {
            \DB::table('payment_methods_universal')->delete();

            $gateways = \App\Enums\PaymentGatewaysEnum::labels();

            if (! empty($gateways)) {
                foreach ($gateways as $gateway => $label) {
                    if (! PaymentMethodUniversal::where('gateway', $gateway)->exists()) {
                        DB::table('payment_methods_universal')->insert([
                            'enabled' => 0,
                            'name' => $label,
                            'gateway' => $gateway,
                            'description' => '',
                            'instructions' => '',
                            'data' => json_encode([]),
                        ]);
                    }
                }
            }
        }
    }
}

<?php

namespace App\Http\Services;


use App\Models\User;
use App\Models\Address;
use Illuminate\Support\Collection;
use Str;

class AuthService
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app();
    }

    /**
     * Attempt to register a ghost-user and send an email to finalize registration on checkout (or Order creation)
     *
     * @param string $email
     */
    public function createGhostUserOnCheckout($order)
    {
        // Check if $user with provided $email exists in DB
        $user = User::where('email', $order->email)->first();

        if(empty($user)) {
            $user = User::create([
                'name' => $order->billing_first_name,
                'surname' => $order->billing_last_name,
                'user_type' => User::$customer_type,
                'email' => $order->email,
                'is_temp' => true,
            ]);

            // Create billing address
            $address_billing = Address::create([
                'user_id' => $user->id,
                'address' => $order->billing_address,
                'address_2' => '',
                'country' => $order->billing_country,
                'state' => empty($order->billing_state) ? $order->billing_country : $order->billing_state,
                'city' => $order->billing_city,
                'zip_code' => $order->billing_zip,
                'phones' => $order->phone_numbers,
                'is_primary' => true,
                'is_shipping' => $order->same_billing_shipping ? true : false
            ]);

            if (empty($order->same_billing_shipping)) {
                // Create another address with shipping info
                $address_shipping = Address::create([
                    'user_id' => $user->id,
                    'address' => $order->shipping_address,
                    'address_2' => '',
                    'country' => $order->shipping_country,
                    'state' => empty($order->shipping_state) ? $order->shipping_country : $order->shipping_state,
                    'city' => $order->shipping_city,
                    'zip_code' => $order->shipping_zip,
                    'phones' => $order->phone_numbers,
                    'is_primary' => false,
                    'is_shipping' => true,
                ]);
            }

            return $user;
        }

        return null;
    }
}

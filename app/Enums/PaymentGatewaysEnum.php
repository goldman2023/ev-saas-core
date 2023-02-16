<?php

namespace App\Enums;

/**
 * @method static self wire_transfer()
 * @method static self paypal()
 * @method static self stripe()
 * @method static self paysera()
 */
class PaymentGatewaysEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'wire_transfer' => 'wire_transfer',
            'paypal' => 'paypal',
            'stripe' => 'stripe',
            'paysera' => 'paysera',
        ];
    }

    public static function labels(): array
    {
        return [
            'wire_transfer' => 'Wire Transfer',
            'paypal' => 'Paypal',
            'stripe' => 'Stripe',
            'paysera' => 'Paysera',
        ];
    }
}

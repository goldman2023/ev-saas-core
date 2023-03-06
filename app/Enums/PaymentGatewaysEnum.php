<?php

namespace App\Enums;

/**
 * @method static self wire_transfer()
 * @method static self cash_on_delivery()
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
            'cash_on_delivery' => 'cash_on_delivery',
            'paypal' => 'paypal',
            'stripe' => 'stripe',
            'paysera' => 'paysera',
        ];
    }

    public static function labels(): array
    {
        return [
            'wire_transfer' => 'Wire Transfer',
            'cash_on_delivery' => 'Cash on Delivery',
            'paypal' => 'Paypal',
            'stripe' => 'Stripe',
            'paysera' => 'Paysera',
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self unpaid()
 * @method static self pending()
 * @method static self canceled()
 * @method static self paid()
 */
class PaymentStatusEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'unpaid' => 'unpaid',
            'pending' => 'pending',
            'canceled' => 'canceled',
            'paid' => 'paid',
        ];
    }

    public static function labels(): array
    {
        return [
            'unpaid' => translate('Unpaid'),
            'pending' => translate('Pending'),
            'canceled' => translate('Canceled'),
            'paid' => translate('Paid'),
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self not_sent()
 * @method static self sent()
 * @method static self delivered()
 */
class ShippingStatusEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'not_sent' => 'not_sent',
            'sent' => 'sent',
            'delivered' => 'delivered',
        ];
    }

    public static function labels(): array
    {
        return [
            'not_sent' => 'Not sent',
            'sent' => 'Sent',
            'delivered' => 'Delivered',
        ];
    }
}

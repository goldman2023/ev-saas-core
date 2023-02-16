<?php

namespace App\Enums;

/**
 * @method static self amount()
 * @method static self percent()
 */
class AmountPercentTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'amount' => 'amount',
            'percent' => 'percent',
        ];
    }

    public static function labels(): array
    {
        return [
            'amount' => 'Amount',
            'percent' => 'Percent',
        ];
    }
}

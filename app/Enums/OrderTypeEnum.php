<?php

namespace App\Enums;

/**
 * @method static self standard()
 * @method static self subscription()
 * @method static self installments()
 */
class OrderTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'standard' => 'standard',
            'subscription' => 'subscription',
            'installments' => 'installments',
        ];
    }

    public static function labels(): array
    {
        return [
            'standard' => 'Standard',
            'subscription' => 'Subscription',
            'installments' => 'Installments',
        ];
    }
}

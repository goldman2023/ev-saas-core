<?php

namespace App\Enums;

/**
 * @method static self amount()
 * @method static self percent()
 */
class UnitsEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'pc' => 'pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz',
            'm' => 'meter(s)',
            's' => 'second(s)'
        ];
    }

    public static function labels(): array
    {
        return [
            'pc' => 'Pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz',
            'm' => 'meter(s)',
            's' => 'second(s)'
        ];
    }
}

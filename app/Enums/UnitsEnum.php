<?php

namespace App\Enums;

/**
 * @method static self pc()
 * @method static self kg()
 * @method static self l()
 * @method static self oz()
 * @method static self m()
 * @method static self s()
 */
class UnitsEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'pc' => 'pc',
            'kg' => 'kg',
            'l' => 'litre',
            'oz' => 'oz',
            'm' => 'meter(s)',
            's' => 'second(s)',
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
            's' => 'second(s)',
        ];
    }
}

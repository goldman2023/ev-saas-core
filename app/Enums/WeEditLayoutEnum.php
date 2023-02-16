<?php

namespace App\Enums;

/**
 * @method static self one()
 * @method static self two()
 * @method static self three()
 */
class WeEditLayoutEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'one' => 'one',
            'two' => 'two',
            'three' => 'three',
        ];
    }

    public static function labels(): array
    {
        return [
            'one' => 'One column',
            'two' => 'Two columns',
            'three' => 'Three columns',
        ];
    }
}

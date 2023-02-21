<?php

namespace App\Enums;

/**
 * @method static self in_stock()
 * @method static self out_of_stock()
 * @method static self reserved()
 */
class SerialNumberStatusEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'in_stock' => 'in_stock',
            'out_of_stock' => 'out_of_stock',
            'reserved' => 'reserved',
        ];
    }

    public static function labels(): array
    {
        return [
            'in_stock' => 'In stock',
            'out_of_stock' => 'Out of stock',
            'reserved' => 'Reserved',
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self quantity()
 * @method static self text()
 * @method static self hide()
 */
class StockVisibilityStateEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'quantity' => 'quantity',
            'text' => 'text',
            'hide' => 'hide',
        ];
    }

    public static function labels(): array
    {
        return [
            'quantity' => 'Quantity',
            'text' => 'Text',
            'hide' => 'Hide',
        ];
    }
}

<?php

namespace WeThemes\WeBaltic\App\Enums;

use App\Enums\WeBaseEnum;

/**
 * @method static self printing()
 * @method static self delivery()
 */
class TaskTypesEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'printing' => 'printing',
            'delivery' => 'delivery',
        ];
    }

    public static function labels(): array
    {
        return [
            'printing' => translate('Printing'),
            'delivery' => translate('Delivery'),
        ];
    }
}

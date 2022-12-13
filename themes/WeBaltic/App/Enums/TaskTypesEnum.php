<?php

namespace WeThemes\WeBaltic\App\Enums;

use App\Enums\EVBaseEnum;

/**
 * @method static self printing()
 * @method static self delivery()
 */
class TaskTypesEnum extends EVBaseEnum
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

<?php

namespace App\Enums;

/**
 * @method static self standard()
 * @method static self digital()
 * @method static self event()
 */
class ProductAddonTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'standard' => 'standard',
            'digital' => 'digital',
            'event' => 'event',
        ];
    }

    public static function labels(): array
    {
        return [
            'standard' => 'Standard',
            'digital' => 'Digital',
            'event' => 'Event',
        ];
    }
}

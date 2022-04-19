<?php

namespace App\Enums;

/**
 * @method static self system()
 * @method static self builder()
 * @method static self html()
 */
class PageTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'system' => 'system',
            'builder' => 'builder',
            'html' => 'html',
        ];
    }

    public static function labels(): array
    {
        return [
            'system' => 'System',
            'builder' => 'Builder',
            'html' => 'Html',
        ];
    }
}
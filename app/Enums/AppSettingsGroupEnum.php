<?php

namespace App\Enums;

/**
 * @method static self general()
 * @method static self notifications()
 */
class AppSettingsGroupEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'general' => 'general',
            'notifications' => 'notifications',
        ];
    }

    public static function labels(): array
    {
        return [
            'general' => 'General',
            'notifications' => 'Notifications',
        ];
    }
}

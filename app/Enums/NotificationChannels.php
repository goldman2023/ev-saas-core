<?php

namespace App\Enums;

/**
 * @method static self database()
 * @method static self mail()
 * @method static self sms()
 */
class NotificationChannelsEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'database' => 'database',
            'mail' => 'mail',
            'sms' => 'sms'
        ];
    }

    public static function labels(): array
    {
        return [
            'database' => 'Database',
            'mail' => 'Mail',
            'sms' => 'SMS'
        ];
    }
}

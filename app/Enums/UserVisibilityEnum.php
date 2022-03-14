<?php

namespace App\Enums;

/**
 * @method static self all()
 * @method static self guest()
 * @method static self auth()
 * @method static self subscriber()
 * @method static self non_subscriber()
 */
class UserVisibilityEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'all' => 'all',
            'guest' => 'guest',
            'auth' => 'auth',
            'subscriber' => 'subscriber',
            'non_subscriber' => 'non_subscriber',
        ];
    }

    public static function labels(): array
    {
        return [
            'all' => 'All',
            'guest' => 'Guests',
            'auth' => 'Authenticated users',
            'subscriber' => 'Subscribers',
            'non_subscriber' => 'Non-subscribers',
        ];
    }
}

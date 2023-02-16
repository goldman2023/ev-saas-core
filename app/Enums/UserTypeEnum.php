<?php

namespace App\Enums;

/**
 * @method static self admin()
 * @method static self moderator()
 * @method static self seller()
 * @method static self staff()
 * @method static self customer()
 */
class UserTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'admin' => 'admin',
            'moderator' => 'moderator',
            'seller' => 'seller',
            'staff' => 'staff',
            'customer' => 'customer',
        ];
    }

    public static function labels(): array
    {
        return [
            'admin' => 'Admin',
            'moderator' => 'Moderator',
            'seller' => 'Seller',
            'staff' => 'Staff',
            'customer' => 'Customer',
        ];
    }
}

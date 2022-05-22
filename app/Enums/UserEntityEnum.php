<?php

namespace App\Enums;

/**
 * @method static self individual()
 * @method static self company()
 */
class UserEntityEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'individual' => 'individual',
            'company' => 'company',
        ];
    }

    public static function labels(): array
    {
        return [
            'individual' => 'Individual',
            'company' => 'Company',
        ];
    }
}

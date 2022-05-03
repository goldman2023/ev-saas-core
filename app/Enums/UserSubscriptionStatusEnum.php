<?php

namespace App\Enums;

/**
 * @method static self active()
 * @method static self inactive()
 * @method static self active_until_end()
 * @method static self trial()
 */
class UserSubscriptionStatusEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'active' => 'active',
            'inactive' => 'inactive',
            'active_until_end' => 'active_until_end',
            'trial' => 'trial',
        ];
    }

    public static function labels(): array
    {
        return [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'active_until_end' => 'Active until end period',
            'trial' => 'Trial',
        ];
    }
}

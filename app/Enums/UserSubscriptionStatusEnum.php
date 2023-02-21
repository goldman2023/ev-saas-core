<?php

namespace App\Enums;

/**
 * @method static self active()
 * @method static self inactive()
 * @method static self canceled()
 * @method static self active_until_end()
 * @method static self trial()
 */
class UserSubscriptionStatusEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'active' => 'active',
            'active_until_end' => 'active_until_end',
            'trial' => 'trial',
            'inactive' => 'inactive',
            'canceled' => 'canceled',
        ];
    }

    public static function labels(): array
    {
        return [
            'active' => 'Active',
            'active_until_end' => 'Active until end period',
            'trial' => 'Trial',
            'inactive' => 'Inactive',
            'canceled' => 'Canceled',
        ];
    }
}

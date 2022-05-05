<?php

namespace App\Enums;

/**
 * @method static self full()
 * @method static self trial()
 * @method static self manual()
 */
class LicenseTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'full' => 'full',
            'trial' => 'trial',
            'manual' => 'manual',
        ];
    }

    public static function labels(): array
    {
        return [
            'full' => 'Full',
            'trial' => 'Trial',
            'manual' => 'Manual',
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self _self()
 * @method static self _blank()
 */
class HrefTargetEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            '_self' => '_self',
            '_blank' => '_blank',
        ];
    }

    public static function labels(): array
    {
        return [
            '_self' => 'Self',
            '_blank' => 'New',
        ];
    }
}

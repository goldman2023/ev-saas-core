<?php

namespace App\Enums;

/**
 * @method static self Plans()
 * @method static self Trial()
 */
class WeMailingSubsribersFieldsEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'Plans' => 'TEXT',
            'Trial' => 'NUMBER',
        ];
    }

    public static function labels(): array
    {
        return [
            'Plans' => 'TEXT',
            'Trial' => 'NUMBER',
        ];
    }
}

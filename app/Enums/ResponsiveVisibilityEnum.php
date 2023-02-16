<?php

namespace App\Enums;

/**
 * @method static self all()
 * @method static self mobile()
 * @method static self tablet_portrait()
 * @method static self tablet_landscape()
 * @method static self laptop()
 * @method static self desktop()
 */
class ResponsiveVisibilityEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'all' => 'all',
            'mobile' => 'mobile',
            'tablet_portrait' => 'tablet_portrait',
            'tablet_landscape' => 'tablet_landscape',
            'laptop' => 'laptop',
            'desktop' => 'desktop',
        ];
    }

    public static function labels(): array
    {
        return [
            'all' => 'All',
            'mobile' => 'Mobile',
            'tablet_portrait' => 'Tablet Portrait +',
            'tablet_landscape' => 'Tablet Landscape +',
            'laptop' => 'Laptop +',
            'desktop' => 'Desktop +',
        ];
    }
}

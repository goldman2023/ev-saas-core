<?php

namespace App\Enums;

/**
 * @method static self color()
 * @method static self gradient()
 * @method static self image()
 * @method static self video()
 */
class BackgroundTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'color' => 'color',
            'gradient' => 'gradient',
            'image' => 'image',
            'video' => 'video',
        ];
    }

    public static function labels(): array
    {
        return [
            'color' => 'Color',
            'gradient' => 'Gradient',
            'image' => 'Image',
            'video' => 'Video',
        ];
    }
}

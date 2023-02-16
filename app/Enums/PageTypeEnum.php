<?php

namespace App\Enums;

/**
 * @method static self system()
 * @method static self builder()
 * @method static self html()
 * @method static self wysiwyg()
 */
class PageTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'system' => 'system',
            'builder' => 'builder',
            'html' => 'html',
            'wysiwyg' => 'wysiwyg',
        ];
    }

    public static function labels(): array
    {
        return [
            'system' => 'System',
            'builder' => 'Builder',
            'html' => 'Html',
            'wysiwyg' => 'Wysiwyg',
        ];
    }
}

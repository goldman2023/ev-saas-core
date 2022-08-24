<?php

namespace App\Enums;

/**
 * @method static self twig()
 * @method static self blade()
 * @method static self builder()
 * @method static self wysiwyg()
 */
class SectionTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'twig' => 'twig',
            'blade' => 'blade',
            'builder' => 'builder',
            'wysiwyg' => 'wysiwyg',
        ];
    }

    public static function labels(): array
    {
        return [
            'twig' => 'Twig',
            'blade' => 'Blade',
            'builder' => 'Builder',
            'wysiwyg' => 'Wysiwyg',
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self twig()
 * @method static self blade_component()
 * @method static self block()
 * @method static self wysiwyg()
 */
class SectionTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'twig' => 'twig',
            'blade_component' => 'blade_component',
            'block' => 'block',
            'wysiwyg' => 'wysiwyg',
        ];
    }

    public static function labels(): array
    {
        return [
            'twig' => 'Twig',
            'blade_component' => 'Blade Component',
            'block' => 'Block',
            'wysiwyg' => 'Wysiwyg',
        ];
    }
}

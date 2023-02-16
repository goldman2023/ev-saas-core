<?php

namespace App\Enums;

/**
 * @method static self h1()
 * @method static self h2()
 * @method static self h3()
 * @method static self h4()
 * @method static self h5()
 * @method static self h6()
 * @method static self p()
 * @method static self span()
 * @method static self strong()
 */
class TitleTagEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'h1' => 'h1',
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'h5' => 'h5',
            'h6' => 'h6',
            'p' => 'p',
            'span' => 'span',
            'strong' => 'strong',
        ];
    }

    public static function labels(): array
    {
        return [
            'p' => 'P',
            'h1' => 'H1',
            'h2' => 'H2',
            'h3' => 'H3',
            'h4' => 'H4',
            'h5' => 'H5',
            'h6' => 'H6',
            'span' => 'Span',
            'strong' => 'Bold',
        ];
    }
}

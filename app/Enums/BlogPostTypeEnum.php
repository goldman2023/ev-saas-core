<?php

namespace App\Enums;

/**
 * @method static self blog()
 * @method static self portfolio()
 */
class BlogPostTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'blog' => 'blog',
            'portfolio' => 'portfolio',
        ];
    }

    public static function labels(): array
    {
        return [
            'blog' => 'Blog',
            'portfolio' => 'Portfolio',
        ];
    }
}

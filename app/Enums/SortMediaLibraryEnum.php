<?php

namespace App\Enums;

/**
 * @method static self newest()
 * @method static self oldest()
 * @method static self smallest()
 * @method static self largest()
 */
class SortMediaLibraryEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'newest' => 'newest',
            'oldest' => 'oldest',
            'smallest' => 'smallest',
            'largest' => 'largest',
        ];
    }

    public static function labels(): array
    {
        return [
            'newest' => 'Sort by newest',
            'oldest' => 'Sort by oldest',
            'smallest' => 'Sort by smallest',
            'largest' => 'Sort by largest',
        ];
    }
}

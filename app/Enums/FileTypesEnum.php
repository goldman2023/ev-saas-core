<?php

namespace App\Enums;

/**
 * @method static self all()
 * @method static self image()
 * @method static self document()
 */
class FileTypesEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'all' => 'all',
            'image' => 'image',
            'document' => 'document',
        ];
    }

    public static function labels(): array
    {
        return [
            'all' => 'All',
            'image' => 'Image',
            'document' => 'Document',
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self all()
 * @method static self images()
 * @method static self documents()
 */
class MediaLibraryFileTypesEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'all' => 'all',
            'images' => 'images',
            'documents' => 'documents',
        ];
    }

    public static function labels(): array
    {
        return [
            'all' => 'All',
            'images' => 'Images',
            'documents' => 'Documents',
        ];
    }
}

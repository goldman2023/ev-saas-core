<?php

namespace App\Enums;

/**
 * @method static self draft()
 * @method static self published()
 * @method static self private()
 * @method static self pending()
 * @method static self archived()
 */
class StatusEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'draft' => 'draft',
            'published' => 'published',
            'private' => 'private',
            'pending' => 'pending',
            'archived' => 'archived',
        ];
    }

    public static function labels(): array
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
            'private' => 'Private',
            'pending' => 'Pending',
            'archived' => 'Archived',
        ];
    }
}

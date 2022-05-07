<?php

namespace App\Enums;

/**
 * @method static self like()
 * @method static self love()
 * @method static self bravo()
 * @method static self hilarious()
 * @method static self sad()
 * @method static self angry()
 * @method static self insightful()
 */
class SocialReactionsEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'like' => 'like',
            'love' => 'love',
            'bravo' => 'bravo',
            'insightful' => 'insightful',
            'hilarious' => 'hilarious',
            'sad' => 'sad',
            'angry' => 'angry',
        ];
    }

    public static function labels(): array
    {
        return [
            'like' => 'Like',
            'love' => 'Love',
            'bravo' => 'Bravo',
            'insightful' => 'Insightful',
            'hilarious' => 'Hilarious',
            'sad' => 'Sad',
            'angry' => 'Angry',
        ];
    }
}

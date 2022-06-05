<?php

namespace App\Enums;

/**
 * @method static self wysiwyg()
 * @method static self video()
 * @method static self quizz()
 */
class CourseItemTypes extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'wysiwyg' => 'wysiwyg',
            'video' => 'video',
            'quizz' => 'quizz',
        ];
    }

    public static function labels(): array
    {
        return [
            'wysiwyg' => 'WYSIWYG',
            'video' => 'Video',
            'quizz' => 'Quizz',
        ];
    }
}

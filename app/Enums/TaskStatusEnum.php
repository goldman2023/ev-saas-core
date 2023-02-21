<?php

namespace App\Enums;

/**
 * @method static self scoping()
 * @method static self backlog()
 * @method static self in_progress()
 * @method static self review()
 * @method static self done()
 */
class TaskStatusEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'scoping' => 'scoping',
            'backlog' => 'backlog',
            'in_progress' => 'in_progress',
            'review' => 'review',
            'done' => 'done',
        ];
    }

    public static function labels(): array
    {
        return [
            'scoping' => 'Scoping',
            'backlog' => 'Backlog',
            'in_progress' => 'In Progress',
            'review' => 'Review',
            'done' => 'Done',
        ];
    }
}

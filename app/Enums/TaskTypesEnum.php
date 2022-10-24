<?php

namespace App\Enums;

/**
 * @method static self issue()
 * @method static self payment()
 * @method static self request()
 * @method static self improvement()
 * @method static self other()
 */
class TaskTypesEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'issue' => 'issue',
            'payment' => 'payment',
            'request' => 'request',
            'improvement' => 'improvement',
            'other' => 'other',
        ];
    }

    public static function labels(): array
    {
        return [
            'issue' => translate('Issue'),
            'payment' => translate('Payment'),
            'request' => translate('Request'),
            'improvement' => translate('Improvement'),
            'other' => translate('Other'),
        ];
    }
}

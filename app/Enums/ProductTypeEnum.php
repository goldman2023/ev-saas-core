<?php

namespace App\Enums;

/**
 * @method static self digital()
 * @method static self event()
 * @method static self standard()
 * @method static self subscription()
 * @method static self physical_subscription()
 * @method static self course()
 * @method static self bookable_service()
 * @method static self bookable_subscription_service()
 */
class ProductTypeEnum extends EVBaseEnum
{
    public static function values(): array
    {
        return [
            'digital' => 'digital',
            'event' => 'event',
            'standard' => 'standard',
            'subscription' => 'subscription',
            'physical_subscription' => 'physical_subscription',
            'course' => 'course',
            'bookable_service' => 'bookable_service',
            'bookable_subscription_service' => 'bookable_subscription_service',
        ];
    }

    public static function labels(): array
    {
        return [
            'digital' => 'Digital',
            'event' => 'Event',
            'standard' => 'Standard',
            'subscription' => 'Subscription',
            'physical_subscription' => 'Physical Subscrption',
            'course' => 'Course',
            'bookable_service' => 'Bookable Service',
            'bookable_subscription_service' => 'Bookable Subscription Service',
        ];
    }
}

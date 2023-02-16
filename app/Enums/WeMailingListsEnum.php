<?php

namespace App\Enums;

/**
 * @method static self all_users()
 * @method static self subscribers()
 * @method static self customers()
 * @method static self newsletter()
 * @method static self deals()
 */
class WeMailingListsEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'all_users' => 'all_users', // All registered users go here
            'subscribers' => 'subscribers', // All users who bought a subscription plan go here
            'customers' => 'customers', // All users who purchased at least one Product (not a Plan)
            'newsletter' => 'newsletter', // All users who want to receive newletters
            'deals' => 'deals' // All users who want to receive special deals
        ];
    }

    public static function labels(): array
    {
        return [
            'all_users' => 'All Users',
            'subscribers' => 'Subscribers',
            'customers' => 'Customers',
            'newsletter' => 'Newsletter',
            'deals' => 'Deals'
        ];
    }
}

<?php

namespace App\Enums;

/**
 * @method static self draft()
 * @method static self published()
 * @method static self private()
 * @method static self pending()
 * @method static self archived()
 */
class OrderStatusEnum extends EVBaseEnum
{
    public static function values(): array
    {
        /* Define your custom statuses here */
        /* TODO: create a filter for this  */
        return [
            0 => 'contract',
            1 => 'approved',
            2 => 'welding',
            3 => 'qa_1',
            4 =>'zincification',
            5 =>'delivery_to_warehouse',
            6 =>'assembly',
            7 =>'qa_2',
            8 =>'certificate',
            9 =>'completed',
            10 =>'customer_reviewed',
        ];
    }

    public static function labels(): array
    {
        return [
            0 => 'Contract',
            1 => 'Approved',
            2 => 'Wellding',
            3 => 'Quality Assurance',
            4 =>'Zincification',
            5 =>'Delivery',
            6 =>'Assembly',
            7 =>'Final Quality Assurance',
            8 =>'Certificate approved',
            9 =>'Completed',
            10 =>'Feedback',
        ];
    }
}

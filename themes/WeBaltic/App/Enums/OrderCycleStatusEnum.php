<?php

namespace WeThemes\WeBaltic\App\Enums;

use App\Enums\EVBaseEnum;

class OrderCycleStatusEnum extends EVBaseEnum
{
    public static function values(): array
    {
        /* Define your custom statuses here */
        /* TODO: create a filter for this  */
        return [
            0 => 'request',
            1 => 'contract',
            2 => 'approved',
            3 => 'welding',
            4 => 'qa_1',
            5 => 'zincification',
            6 => 'delivery_to_warehouse',
            7 => 'assembly',
            8 => 'qa_2',
            9 => 'certificate',
            10 => 'completed',
            11 => 'customer_reviewed',
        ];
    }

    public static function labels(): array
    {
        return [
            0 => 'Request',
            1 => 'Contract',
            2 => 'Approved',
            3 => 'Wellding',
            4 => 'Quality Assurance',
            5 => 'Zincification',
            6 => 'Delivery',
            7 => 'Assembly',
            8 => 'Final Quality Assurance',
            9 => 'Certificate approved',
            10 => 'Completed',
            11 => 'Customer feedback',
        ];
    }
}

<?php

namespace WeThemes\WeBaltic\App\Enums;

use App\Enums\WeBaseEnum;

class OrderCycleStatusEnum extends WeBaseEnum
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
            6 => 'delivery_to_warehouse',
            5 => 'zincification',
            7 => 'assembly',
            8 => 'qa_2',
            9 => 'certificate',
            10 => 'completed',
            11 => 'customer_reviewed',
            12 => 'final',
        ];
    }

    public static function labels(): array
    {
        return [
            0 => translate('Request'),
            1 => translate('Contract'),
            2 => translate('Approved'),
            3 => translate('Wellding'),
            4 => translate('Quality Assurance'),
            6 => translate('Delivery'),
            5 => translate('Zincification'),
            7 => translate('Assembly'),
            8 => translate('Final Quality Assurance'),
            9 => translate('Certificate approved'),
            10 => translate('Completed'),
            11 => translate('Customer feedback'),
            12 => translate('Finalized Orders'),

        ];
    }

    public static function getPublicStatuses() {
        return array_intersect(self::values(), ['request', 'contract', 'approved', 'completed', 'customer_reviewed']);
    }

    public static function getPublicStatusesLabels() {
        return array_intersect_key(self::labels(), self::getPublicStatuses());
    }

    public static function getPublicStatusesDescriptions() {
        return [
            0 => translate('Requested quote is under review'),
            1 => translate('Waiting for customer contract signing'),
            2 => translate('Contract signed & approved by customer'),
            // 3 => translate('Wellding'),
            // 4 => translate('Quality Assurance'),
            // 6 => translate('Delivery'),
            // 5 => translate('Zincification'),
            // 7 => translate('Assembly'),
            // 8 => translate('Final Quality Assurance'),
            // 9 => translate('Certificate approved'),
            10 => translate('Order completed and products sent'),
            11 => translate('Awaiting customer feedback'),
        ];
    }
}

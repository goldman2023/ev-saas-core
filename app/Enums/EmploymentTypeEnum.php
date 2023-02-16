<?php

namespace App\Enums;

/**
 * @method static self contract()
 * @method static self self_employed()
 * @method static self part_time()
 * @method static self full_time()
 * @method static self internship()
 * @method static self apprenticeship()
 * @method static self freelance()
 */
class EmploymentTypeEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return [
            'contract' => 'contract',
            'self_employed' => 'self_employed',
            'part_time' => 'part_time',
            'full_time' => 'full_time',
            'internship' => 'internship',
            'apprenticeship' => 'apprenticeship',
            'freelance' => 'freelance',
        ];
    }

    public static function labels(): array
    {
        return [
            'contract' => 'Contract',
            'self_employed' => 'Self Employed',
            'part_time' => 'Part time',
            'full_time' => 'Full time',
            'internship' => 'Internship',
            'apprenticeship' => 'Apprenticeship',
            'freelance' => 'Freelance',
        ];
    }
}
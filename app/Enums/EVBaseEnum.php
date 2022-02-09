<?php

namespace App\Enums;

use \Spatie\Enum\Enum;


class EVBaseEnum extends Enum
{
    public static function toArray($skip = null): array
    {
        $new_array = [];
        $array = parent::toArray();

        foreach ($array as $value => $label) {
            if((is_string($skip) && $skip === $value) || (is_array($skip) && in_array($value, $skip))) {
                continue;
            }

            $new_array[$value] = $label;
        }

        return $new_array;
    }

    /**
     * @return string[]|int[]
     */
    public static function toValues($skip = null): array
    {
        return array_keys(static::toArray($skip));
    }

    /**
     * @return string[]
     */
    public static function toLabels($skip = null): array
    {
        return array_values(static::toArray($skip));
    }

    public static function implodedValues($skip = null, $separator = ', '): string
    {
        return implode($separator, self::toValues($skip));
    }

    public static function implodedLabels($skip = null, $separator = ', '): string
    {
        return implode($separator, self::toLabels($skip));
    }
}

<?php

namespace App\Enums;

use Spatie\Enum\Enum;

class EVBaseEnum extends Enum
{
    // ALWAYS RETURNS EMPTY ARRAY! DON'T USE IT...
    public static function toArray($skip = null): array
    {
        $new_array = [];
        $array = parent::toArray(); // TODO: THIS DOES NOT WORK FOR SOME WEIRD REASON!

        foreach ($array as $value => $label) {
            if ((is_string($skip) && $skip === $value) || (is_array($skip) && in_array($value, $skip))) {
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
        $new = [];

        foreach (static::values() as $value => $label) {
            if ((is_string($skip) && $skip === $value) || (is_array($skip) && in_array($value, $skip))) {
                continue;
            }

            $new[$value] = $label;
        }

        return array_keys($new);
    }

    /**
     * @return string[]
     */
    public static function toLabels($skip = null): array
    {
        $new = [];

        foreach (static::labels() as $value => $label) {
            if ((is_string($skip) && $skip === $value) || (is_array($skip) && in_array($value, $skip))) {
                continue;
            }

            $new[$value] = $label;
        }

        return array_keys($new);
    }

    public static function implodedValues($skip = null, $separator = ', '): string
    {
        return implode($separator, self::toValues($skip));
    }

    public static function implodedLabels($skip = null, $separator = ', '): string
    {
        return implode($separator, self::toLabels($skip));
    }

    public static function getLabel($key) {
        return static::labels()[$key] ?? null;
    }
}

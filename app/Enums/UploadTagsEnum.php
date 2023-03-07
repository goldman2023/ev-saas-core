<?php

namespace App\Enums;

class UploadTagsEnum extends WeBaseEnum
{
    public static function values(): array
    {
        return array_filter('enums.upload_tags.values', [

        ]);
    }

    public static function labels(): array
    {
        return array_filter('enums.upload_tags.labels', [

        ]);
    }
}

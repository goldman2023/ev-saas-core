<?php

namespace App\Http\Services;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryRelationship;
use App\Models\Currency;
use App\Models\Product;
use App\Models\Shop;
use App\Models\ShopDomain;
use Cache;
use EVS;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use Session;

class MediaService
{
    public function __construct($app)
    {
    }

    public function getPermittedExtensions()
    {
        return [
            'jpg'=>'image',
            'jpeg'=>'image',
            'png'=>'image',
            'svg'=>'image',
            'webp'=>'image',
            'gif'=>'image',
            'mp4'=>'video',
            'mpg'=>'video',
            'mpeg'=>'video',
            'webm'=>'video',
            'ogg'=>'video',
            'avi'=>'video',
            'mov'=>'video',
            'flv'=>'video',
            'swf'=>'video',
            'mkv'=>'video',
            'wmv'=>'video',
            'wma'=>'audio',
            'aac'=>'audio',
            'wav'=>'audio',
            'mp3'=>'audio',
            'zip'=>'archive',
            'rar'=>'archive',
            '7z'=>'archive',
            'doc'=>'document',
            'txt'=>'document',
            'docx'=>'document',
            'pdf'=>'document',
            'csv'=>'document',
            'xml'=>'document',
            'ods'=>'document',
            'xlr'=>'document',
            'xls'=>'document',
            'xlsx'=>'document',
        ];
    }
}

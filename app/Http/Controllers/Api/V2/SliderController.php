<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\SliderCollection;

class SliderController extends Controller
{
    public function index()
    {
        return new SliderCollection(get_setting('home_slider_images'));
    }
}

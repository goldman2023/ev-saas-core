<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\SliderCollection;

class SliderController extends Controller
{
    public function index()
    {
        return new SliderCollection(get_setting('home_slider_images'));
    }
}

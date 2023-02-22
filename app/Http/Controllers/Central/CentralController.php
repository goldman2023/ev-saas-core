<?php

namespace App\Http\Controllers\Central;

use App\Http\Controllers\Controller;
use App\Models\Central\Tenant;
use Illuminate\Http\Request;

class CentralController extends Controller
{
    public function index()
    {
        return view('central.landing-pages.landing');
    }

    public function page($slug)
    {
        return view('central.landing-pages.' . $slug);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeAnalyticsController extends Controller
{
    //
    public function index() {
        return view('analytics.index');
    }
}

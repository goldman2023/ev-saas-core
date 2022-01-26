<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class weMenuController extends Controller
{
    //
    public function index() {
        return view('frontend.dashboard.menu.index');
    }
}

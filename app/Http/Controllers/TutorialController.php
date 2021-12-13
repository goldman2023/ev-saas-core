<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TutorialController extends Controller
{
    //

    public function index()
    {
        return view('frontend.tutorial.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GrapeController extends Controller
{
    //

    public function index() {
        return view('grape.index');
    }
}

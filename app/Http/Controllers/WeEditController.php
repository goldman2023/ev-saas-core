<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WeEditController extends Controller
{
    //
    public function index() {
        return view('we-edit.index');
    }

    public function flow() {
        return view('we-edit.flow');
    }
}

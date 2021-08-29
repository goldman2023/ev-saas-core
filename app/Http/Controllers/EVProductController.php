<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EVProductController extends Controller
{
    //


    public function index() {

        return view('frontend.user.crud.products.index');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SocialCommerceController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.social-commerce.index');
    }
}

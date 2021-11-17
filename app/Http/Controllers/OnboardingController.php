<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    //
    public function welcome() {
        return view('frontend.onboarding.welcome');
    }
}

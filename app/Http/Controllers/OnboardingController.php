<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    //
    public function welcome() {
        return view('frontend.onboarding.welcome');
    }

    public function step2() {
        return view('frontend.onboarding.step2');

    }

    public function profile_store() {

        return redirect()->route('onboarding.step3');
    }

    public function step3() {
        return view('frontend.onboarding.step3');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\OTPVerificationController;
use App\Models\Customer;
use App\Models\OtpConfiguration;
use App\Models\TenantSetting;
use App\Models\User;
use Cookie;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Nexmo;
use Twilio\Rest\Client;

class RegisterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Display users registration page
     */
    public function user_registration(Request $request, $token = null)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        if(!empty($token)) {
            return view('auth.register', compact('token'));
        }

        return view('auth.register');
    }

    public function user_finalize_registration(Request $request, $id, $hash) {
        if (Auth::check() || !User::find($id)->exists()) {
            return redirect()->route('home');
        }

        $ghost_user = User::find($id);

        if(!empty($ghost_user) && !empty($hash) && $hash === sha1($ghost_user->id.'_'.$ghost_user->email)) {
            dd($ghost_user);
            return view('auth.register', compact('ghost_user'));
        }

        return view('auth.register');
    }

    /**
     * Display business registration page
     */
    public function business_registration(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }
}

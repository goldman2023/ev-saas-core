<?php

namespace App\Http\Controllers;

use App\Models\User;
use MyShop;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Spatie\Activitylog\Models\Activity;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class EVAccountVerificationController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::DASHBOARD;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        // $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    public function verification_page(Request $request) {
        if(empty($request->user()))
            abort(404);

        return $request->user()?->hasVerifiedEmail()
                        ? redirect($this->redirectPath()) // go to dashboard if email is verified!
                        : view('auth.verification-page', [
                            'user' => $request->user()
                        ]);
    }

    public function verify(EmailVerificationRequest $request) {
        $request->fulfill();

        if(!empty(get_tenant_setting('register_redirect_url', null))) {
            return redirect(get_tenant_setting('register_redirect_url')); 
        }

        return redirect($this->redirectTo);
    }

    public function resend(Request $request) {
        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Verification link sent!');
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\SecondEmailVerifyMailManager;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Mail;
use Auth;
use Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

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
     * Display forgot password page
     */
    public function forgot_password()
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        return view('auth.forgot-password');
    }

    /**
     * Display reset password page
     */
    public function reset_password(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('home');
        }

        $code = $request->code;
        $email = $request->email;

        $valid = false;

        if(!empty($code) && !empty($email)) {
            $user = User::where([
                ['email', $email],
                ['verification_code', $code]
            ])->first();

            // If email and verification code are correct, and if last time user was updated was max 1hrs ago (means that reset pass was initiated maximally 1h ago)
            if(!empty($user) && $user->updated_at->diffInHours(Carbon::now(), false) < 1) {
                $valid = true;
            }
        }

        return view('auth.reset-password', compact('user', 'valid'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        if (filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $user = User::where('email', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000, 999999);
                $user->save();

                $array['view'] = 'emails.verification';
                $array['from'] = env('MAIL_USERNAME');
                $array['subject'] = translate('Password Reset');
                $array['content'] = translate('Verification Code is ').$user->verification_code;

                Mail::to($user->email)->queue(new SecondEmailVerifyMailManager($array));

                return view('auth.passwords.reset');
            } else {
                flash(translate('No account exists with this email'))->error();

                return back();
            }
        } else {
            $user = User::where('phone', $request->email)->first();
            if ($user != null) {
                $user->verification_code = rand(100000, 999999);
                $user->save();
                sendSMS($user->phone, env('APP_NAME'), $user->verification_code.translate(' is your verification code'));

                return view('otp_systems.frontend.auth.passwords.reset_with_phone');
            } else {
                flash(translate('No account exists with this phone number'))->error();

                return back();
            }
        }
    }
}

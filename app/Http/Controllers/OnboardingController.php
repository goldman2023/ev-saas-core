<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    //
    public function welcome()
    {
        return view('frontend.onboarding.welcome');
    }

    public function step2()
    {
        return view('frontend.onboarding.step2');
    }

    public function profile_store()
    {

        return redirect()->route('onboarding.step3');
    }

    public function step3()
    {
        $user = auth()->user();
        $shop = new Shop();
        $shop->name = 'Your Shop';
        /* @vukasin TODO: Replace this with new way of adding address */
        // $shop->address = $request->address;
        $shop->slug = preg_replace('/\s+/', '-', $shop->name) . '-' . $shop->id;

        if ($shop->save()) {
            $shop->users()->attach($user);
            if (get_setting('email_verification') != 1) {

                // Notification::send(User::where('id', '!=', $user->id)->get(), new NewCompanyJoin($user));
            } else {
                // $user->notify(new EmailVerificationNotification());
            }

            $user->email_verified_at = date('Y-m-d H:m:s');
            $user->save();

            dd($user->shop);
            flash(translate('Your Company has been created successfully!'))->success();
        }

        return view('frontend.onboarding.step3');
    }
}

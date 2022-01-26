<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SocialAccount;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use MehediIitdu\CoreComponentRepository\CoreComponentRepository;
use Illuminate\Support\Str;

class SocialController extends Controller
{

    use AuthenticatesUsers;

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectLoginToProvider(Request $request, $provider)
    {
        return Socialite::setConnectionType('login')->driver($provider)->redirect();
    }

    public function redirectConnectToProvider(Request $request, $provider)
    {
        return Socialite::setConnectionType('connect')->driver($provider)->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderLoginCallback(Request $request, $provider)
    {
        try {
            if($provider === 'twitter') {
//                Stateless authentication is not available for the Twitter driver, which uses OAuth 1.0 for authentication.
                $user = Socialite::driver('twitter')->user();
            }
            else{
                $user = Socialite::driver($provider)->stateless()->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('business.login');
        }

        // check if they're an existing user
        $existingUser = User::where('provider_id', $user->id)->orWhere('email', $user->email)->first();
        dd($existingUser);
        if($existingUser){
            // log them in
            auth()->login($existingUser, true);
        } else {
            // create a new user
            $newUser                  = new User;
            $newUser->name            = $user->name;
            $newUser->email           = $user->email;
            $newUser->email_verified_at = date('Y-m-d H:m:s');
            $newUser->provider_id     = $user->id;
            $newUser->save();

            $customer = new Customer;
            $customer->user_id = $newUser->id;
            $customer->save();

            auth()->login($newUser, true);
        }
        if(session('link') != null){
            return redirect(session('link'));
        }
        else{
            return redirect()->route('dashboard');
        }
    }

    public function handleProviderConnectCallback(Request $request, $provider)
    {
        try {
            if($provider === 'twitter') {
                // Stateless authentication is not available for the Twitter driver, which uses OAuth 1.0 for authentication.
                $user = Socialite::setConnectionType('connect')->driver('twitter')->user();
            } else {
                $user = Socialite::setConnectionType('connect')->driver($provider)->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('business.login');
        }

        $existingUser = User::where('email', $user->email)->first();

        if($existingUser) {
            $social_account = SocialAccount::where([
                ['user_id', '=', auth()->user()->id],
                ['provider', '=', $provider],
            ])->first();
        } else {
            $social_account = auth()->user()->social_accounts()->where('provider', $provider)->first();
        }

        if(!empty($social_account)) {
            $social_account->connected = true;
            $social_account->save();
        } else {
            $social_account = SocialAccount::create([
                'user_id' => auth()->user()->id,
                'provider' => $provider,
                'connected' => 1,
                'data' => collect($user)->toArray(),
            ]);
        }

        dd($social_account);
    }
}

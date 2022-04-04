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
use \App\Support\WeSocialite;

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
        return WeSocialite::configDriver($request, $provider)->redirect();
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
                // Stateless authentication is not available for the Twitter driver, which uses OAuth 1.0 for authentication.
                $user = Socialite::driver('twitter')->user();
            } else{
                $user = WeSocialite::configDriver($request, $provider)->stateless()->user();
            }
        } catch (\Exception $e) {
            flash("Something Went wrong. Please try again.")->error();
            return redirect()->route('home');
        }

        // Check if they're an existing user
        $existingUser = User::where('email', $user->email)->first();
        
        if($existingUser){
            // Log them in
            auth()->login($existingUser, true);
        } else {
            // Create a new user
            $newUser = new User;
            $newUser->user_type = User::$customer_type;
            $newUser->first_name = $user->name; // TODO: FIX THIS to use both first and last name!!!!
            $newUser->email = $user->email;
            $newUser->email_verified_at = date('Y-m-d H:m:s');
            $newUser->provider_id = $user->id; // TODO: We should add provider_ids to CoreMeta, because one user can login with multiple social accounts to the same account - if social account have the same email)
            $newUser->save();

            // TODO: Add avatar to uploads -> uplaod it to Cloud and link user to it
            
            auth()->login($newUser, true);
        }

        if(session('link') != null){
            return redirect(session('link'));
        } else {
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

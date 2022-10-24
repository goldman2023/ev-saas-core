<?php

namespace App\Http\Controllers;

use Cookie;
use MyShop;
use Session;
use Permissions;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Exceptions\WeAPIException;
use App\Enums\AppSettingsGroupEnum;
use App\Models\PaymentMethodUniversal;
use Spatie\Activitylog\Models\Activity;
use Mpociot\VatCalculator\Facades\VatCalculator;

class EVAccountController extends Controller
{
    public function frontend_user_profile(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            $data = Activity::whereNotIn('description', ['viewed', 'deleted', 'updated', 'liked', 'add_to_cart'])
                ->whereNotIn('subject_type', ['Spatie\Activitylog\Models\Activity', 'App/Models/User'])
                ->whereHas('subject')
                ->where('causer_id', $id)
                ->get();

                if(auth()->user()) {
                    activity()
                    ->performedOn($user)
                    ->causedBy(auth()->user())
                    ->withProperties([
                        'action' => 'viewed',
                        'action_title' => 'viewed a profile',
                    ])
                    ->log('viewed');
                } else {
                    $user = null;
                }

            return view('frontend.user.profile', compact(['user', 'data']));
        } catch (\Exception $e) {
            // Create error handling for not found exception to go to 404 page...
        }
    }

    public function user_profile(Request $request, $id)
    {
        try {
            abort(404);
            // $user = User::findOrFail($id);
            
            // return view('frontend.dashboard.users.account-settings', compact('user'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function user_details(Request $request, $id)
    {
        try {
            \Permissions::canAccess(
                user_types: User::$non_customer_user_types,
                permissions: ['view_customer'],
                // redirect_url: route('user.details', auth()->user()?->id), 
                // fallback: function() use($id) {
                //     return auth()->user()->id === (int) $id;
                // }
            );

            $user = User::findOrFail($id);

            return view('frontend.dashboard.users.user-details', compact('user'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

    public function account_settings()
    {
        $me = auth()->user()->load('social_accounts');

        return view('frontend.dashboard.settings.account-settings', compact('me'));
    }

    public function app_settings($settings_group = null)
    {
        $title = translate('Application settings');

        if($settings_group === AppSettingsGroupEnum::notifications()->value) {
            $title = translate('Notifications settings');
        }

        return view('frontend.dashboard.settings.app-settings', compact('settings_group', 'title'));
    }

    public function business_profile()
    {
        return view('frontend.dashboard.settings.business-profile');
    }

    public function design_settings_store(Request $request)
    {
        $domain = tenant()->domains()->first();
        $domain->theme = $request->theme;
        $domain->save();

        return redirect()->back();
    }

    public function domain_settings()
    {
        return view('frontend.dashboard.settings.domain-settings');
    }

    public function payment_methods_settings()
    {
        if (auth()->user()->isAdmin()) {
            $universal_payment_methods = PaymentMethodUniversal::all();
        } else {
            $universal_payment_methods = PaymentMethodUniversal::where('enabled', 1)->get();
        }

        $my_universal_payment_methods = MyShop::getShop()->payment_methods_universal()->wherePivot('enabled', 1)->get();

        $custom_payment_methods = MyShop::getShop()->payment_methods()->get();

        return view('frontend.dashboard.settings.payment-methods-settings', compact('universal_payment_methods', 'my_universal_payment_methods', 'custom_payment_methods'));
    }

    public function staff_settings(Request $request)
    {
        // Allow access to this page only if current user is Admin or Seller (admin of the current shop).
        // Basically, if user has permissions to change other users permissions

        $users = MyShop::getShop()->users;
        $all_roles = \Permissions::getRoles(from_db: true);

        return view('frontend.dashboard.settings.staff-settings', compact('users', 'all_roles'));
    }

    public function shop_settings(Request $request)
    {
        try {
            Permissions::canAccess(User::$non_customer_user_types, ['view_shop_data', 'view_shop_settings']);

        } catch(\Exception $e) {
            return redirect()->route('onboarding.step3');
        }


        $shop = MyShop::getShop();

        return view('frontend.dashboard.settings.shop-settings', compact('shop'));
    }

    // API Routes
    public function api_search_users(Request $request) {
        if(auth()->user()->isAdmin()) {
            $q = $request->q;

            $results = User::search($q)->get();

            // TODO: Return this as an API RESOURCE!
            return response()->json([
                'status' => 'success',
                'results' => $results
            ]);
        }

        throw new WeAPIException(message: translate('Cannot search users if not admin or moderator'), type: 'WeApiException', code: 403);
    }

    public function validateVAT(Request $request) {
        $vat = $request->vat;
        $country = $request->country;

        if(!empty($vat) && !empty($country = \Countries::get(code: $country))) {
            if(\Countries::isEU($country)) {
                try {
                    // VAT Number MUST INCLUDE COUNTRY TWO-LETTER CODE AT THE BEGINNING
                    $validVAT = VatCalculator::isValidVATNumber($vat);
                    
                    // // Check if VAT number country is aligned with user selected country (compare codes)
                    // if($validVAT) {
                    //     $validVAT = strtoupper(substr($vat, 0, 2)) === strtoupper($country);
                    // }

                    return response()->json([
                        'status' => 'success',
                        'is_vat_valid' => $validVAT,
                        'is_country_eu' => true,
                        'message' => $validVAT ? translate('VAT is valid') : translate('VAT is invalid'),
                    ]);
                } catch (VATCheckUnavailableException $e) {
                    // The VAT check API is unavailable...
                    \Log::warning($e);
                    throw new WeAPIException(message: translate('Couldn\'t validate VAT number - Service unavailable.'), type: 'WeApiException', code: 400);
                }
            }

            return response()->json([
                'status' => 'success',
                'is_vat_valid' => false,
                'is_country_eu' => false,
            ]);
        }

        throw new WeAPIException(message: translate('VAT or Country not provided'), type: 'WeApiException', code: 400);
    }


}

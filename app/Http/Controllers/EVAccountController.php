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

class EVAccountController extends Controller
{
    public function user_profile(Request $request, $id) {
        try {
            $user = User::findOrFail($id);


            return view('frontend.dashboard.users.account-settings', compact('user'));
        } catch(\Exception $e) {
            // Create error handling for not found exception to go to 404 page...
        }
    }

    public function account_settings()
    {
        $me = auth()->user()->load('social_accounts');

        return view('frontend.dashboard.settings.account-settings', compact('me'));
    }

    public function app_settings()
    {
        return view('frontend.dashboard.settings.app-settings');
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
        if(auth()->user()->isAdmin()) {
            $universal_payment_methods = PaymentMethodUniversal::all();
        } else {
            $universal_payment_methods = PaymentMethodUniversal::where('enabled', 1)->get();
        }

        $my_universal_payment_methods = MyShop::getShop()->payment_methods_universal()->wherePivot('enabled', 1)->get();

        $custom_payment_methods = MyShop::getShop()->payment_methods()->get();

        return view('frontend.dashboard.settings.payment-methods-settings', compact('universal_payment_methods', 'my_universal_payment_methods', 'custom_payment_methods'));
    }

    public function staff_settings(Request $request) {
        // Allow access to this page only if current user is Admin or Seller (admin of the current shop).
        // Basically, if user has permissions to change other users permissions

        $users = MyShop::getShop()->users;
        $all_roles = \Permissions::getRoles(from_db: true);

        return view('frontend.dashboard.settings.staff-settings', compact('users', 'all_roles'));
    }

    public function shop_settings(Request $request) {
        Permissions::canAccess(User::$non_customer_user_types, ['view_shop_data', 'view_shop_settings']);

        $shop = MyShop::getShop();

        return view('frontend.dashboard.settings.shop-settings', compact('shop'));
    }
}

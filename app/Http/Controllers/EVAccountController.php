<?php

namespace App\Http\Controllers;

use MyShop;
use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use Illuminate\Http\Request;
use Session;
use Cookie;

class EVAccountController extends Controller
{
    public function design_settings()
    {
        return view('frontend.dashboard.settings.design-settings');
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

    public function users_settings(Request $request) {
        // Allow access to this page only if current user is Admin or Seller (admin of the current shop).
        // Basically, if user has permissions to change other users permissions

        $users = MyShop::getShop()->users;
        return view('frontend.dashboard.settings.users-settings', compact('users'));
    }
}

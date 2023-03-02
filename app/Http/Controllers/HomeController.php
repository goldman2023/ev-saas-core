<?php

namespace App\Http\Controllers;

use Hash;
use App\Models\Page;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the customer/seller dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        if (auth()->user()->isSeller()) {
            return view('frontend.user.seller.dashboard');
        } elseif (auth()->user()->isStaff()) {
            return view('frontend.user.staff.dashboard');
        } elseif (auth()->user()->isCustomer()) {
            return view('frontend.user.customer.dashboard');
        } elseif (auth()->user()->isAdmin()) {
            return view('frontend.user.admin.dashboard');
        }
    }

    public function profile(Request $request)
    {
        if (auth()->user()->isCustomer()) {
            return view('frontend.user.customer.profile');
        } elseif (auth()->user()->isSeller()) {
            return view('frontend.user.seller.profile');
        } else {
            return view('frontend.user.customer.profile');
        }
    }

    /**
     * Show the application frontend home.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $products = Product::fromCache()->paginate(12);

        /* Important, if vendor site is activated, then homepage is replaced with single-vendor page */

        /* Check if feed is disabled for this tenant */
        $page = Page::where('slug', 'home')->first();
        $sections = $page->content;
        /* Example usage of TenantSetting for feature detection */
        if (get_tenant_setting('feed_enabled', true)) {
            if (auth()->user()) {
                return redirect()->route('feed.index');
            } else {
                if ($page != null) {
                    return view('frontend.custom_page', [
                        'page' => $page,
                        'sections' => $sections,
                    ]);
                } else {
                    return view('frontend.index');
                }
            }
        } else {
            if ($page != null) {
                return view('frontend.custom_page', [
                    'page' => $page,
                    'sections' => $sections,
                ]);
            }
        }

        return view('frontend.index');
    }

    public function trackOrder(Request $request)
    {
        if ($request->has('order_code')) {
            $order = Order::where('code', $request->order_code)->first();
            if ($order != null) {
                return view('frontend.track_order', compact('order'));
            }
        }

        return view('frontend.track_order');
    }

    public function reset_password_with_code(Request $request)
    {
        if (($user = User::where('email', $request->email)->where('verification_code', $request->code)->first()) != null) {
            if ($request->password == $request->password_confirmation) {
                $user->password = Hash::make($request->password);
                $user->email_verified_at = date('Y-m-d h:m:s');
                $user->save();
                event(new PasswordReset($user));
                auth()->login($user, true);

                flash(translate('Password updated successfully'))->success();

                if (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('home');
            } else {
                flash("Password and confirm password didn't match")->warning();

                return back();
            }
        } else {
            flash('Verification code mismatch')->error();

            return back();
        }
    }
}

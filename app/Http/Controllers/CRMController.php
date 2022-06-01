<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\PaymentMethodUniversal;
use App\Models\User;
use App\Enums\UserTypeEnum;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;
use Spatie\Activitylog\Models\Activity;

class CRMController extends Controller
{
    public function customers_index(Request $request)
    {
        // Allow access to this page only if current user is Admin or Seller/Staff who has `browse_customers` permission

        // TODO: If admin, show all customers, if seller or stuff with `browse_customers` permission, show customers of their Shop!
        // $customers = User::where('user_type', UserTypeEnum::customer()->value)->get(); 

        return view('frontend.dashboard.crm.customers.index', );
    }

    
}

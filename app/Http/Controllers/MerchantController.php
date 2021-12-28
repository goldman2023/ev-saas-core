<?php

namespace App\Http\Controllers;

use App\Models\Seller;
use App\Models\Shop;
use App\Notifications\CompanyVisit;
use Illuminate\Http\Request;
use App\Traits\LoggingTrait;


class MerchantController extends Controller
{
    //
    use LoggingTrait;

    public function index() {

        return view('frontend.shop_listing');
    }

    public function shop($slug)
    {
        $shop = Shop::where('slug', $slug)->first();

        if (!empty($shop)) {
            $seller = $shop->seller();

            if(auth()->check()) {
                $user = auth()->user();

            } else {
                $user = null;
            }

            activity()
                ->performedOn($shop)
                ->causedBy($user)
                ->withProperties(['action' => 'viewed'])
                ->log('User viewed a company page');

            // Seo integration with Schema.org
            if (get_setting('enable_seo_company') == "on") {
                seo()->addSchema($seller->get_schema());
            }

            /* TODO: Shop shop page only after veiriication
            - verification_status column on $seller does not exists,
            what is replacement?
            */
                return view('frontend.company.profile', compact('shop', 'seller'));

            // Show company profile only for company owner user
            if ($seller->user->id === auth()->user()->id ?? null) {
                return view('frontend.company.profile', compact('shop', 'seller'));
            }

            // Show company profile without verification tag to other people
            return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
        }

        abort(404);
    }
}

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

    public function shop($slug)
    {
        $shop  = Shop::where('slug', $slug)->first();
        if ($shop != null) {
            $seller = Seller::where('user_id', $shop->user_id)->first();
            if (auth()->user()) {
                visits($seller, "auth")->increment();
                if (auth()->user()->id != $shop->user->id) {
                    try{
                        /* TODO: Fix this and make sure slack error does not break page */
                     //   $shop->user->notify(new CompanyVisit(auth()->user()));
                    } catch(Exception $e) {

                    }
                }
                $this->log($seller, "user visited a company profile");
            } else {
                visits($seller)->increment();
            }

            // Seo integration with Schema.org
            if (get_setting('enable_seo_company') == "on") {
                seo()->addSchema($seller->get_schema());
            }

            if ($seller->verification_status != 0) {
                return view('frontend.company.profile', compact('shop', 'seller'));
            } else {
                $company_owner_id = $seller->user->id;
                if (auth()->user()) {
                    $current_user_id = auth()->user()->id;
                } else {
                    $current_user_id = 0;
                }

                /* Show company profile for company owner user */
                if ($company_owner_id === $current_user_id) {
                    return view('frontend.company.profile', compact('shop', 'seller'));
                } else {
                    return view('frontend.seller_shop_without_verification', compact('shop', 'seller'));
                }
            }
        }
        abort(404);
    }
}

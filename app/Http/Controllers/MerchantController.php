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
        $shop = Shop::where('slug', $slug)->first();

        if (!empty($shop)) {
            $seller = $shop->seller();

            // Increment visits of the company page!
            if (auth()->user()) {
                visits($seller->user, "auth")->increment();

                if (auth()->user()->id !== $seller->user->id) {
                    // If logged user is NOT actually a seller account of the shop/business!
                    $this->log($seller->user, "User visited a company profile");

                    try{
                        /* TODO: Fix this and make sure slack error does not break page */
                     //   $shop->user->notify(new CompanyVisit(auth()->user()));
                    } catch(\Exception $e) {

                    }
                }
            } else {
                visits($seller->user)->increment();
            }

            // Seo integration with Schema.org
            if (get_setting('enable_seo_company') == "on") {
                seo()->addSchema($seller->get_schema());
            }

            if ($seller->verification_status !== 0) {
                return view('frontend.company.profile', compact('shop', 'seller'));
            }

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

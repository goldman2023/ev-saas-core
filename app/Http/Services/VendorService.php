<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Models\Shop;
use App\Models\ShopDomain;
use Cache;
use EVS;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Facades\Request;
use Illuminate\View\ComponentAttributeBag;
use Session;

class VendorService
{
    public function __construct($app) {

    }

    public function isVendorSite(): bool
    {
        $domain = parse_url(Request::root())['host'] ?? null;
        //$tenant_domains = tenant()->domains()->get()->pluck('domain')->toArray();
        $vendor_domains = tenant()->vendor_domains()->pluck('domain')->toArray();

        if(in_array($domain, $vendor_domains, true)) {
            return true;
        }

        return false;
    }

    public function getGlobalShop() {
        $domain = parse_url(Request::root())['host'] ?? null;
        $shop_domain = ShopDomain::where('domain', '=', $domain)->first();

        return $shop_domain->shop ?? null;
    }
}

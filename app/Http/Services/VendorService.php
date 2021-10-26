<?php

namespace App\Http\Services;

use App\Models\CategoryRelationship;
use App\Models\Currency;
use App\Models\Product;
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
    protected $vendor_shop;
    protected $is_vendor_site;
    protected $vendor_categories_ids;

    public function __construct($app) {
        $this->is_vendor_site = false;
        $this->vendor_shop = null;
        $this->vendor_categories = null;
    }

    public function isVendorSite(): bool
    {
        if(!$this->is_vendor_site) {
            $domain = parse_url(Request::root())['host'] ?? null;
            //$tenant_domains = tenant()->domains()->get()->pluck('domain')->toArray();
            $vendor_domains = tenant()->vendor_domains()->pluck('domain')->toArray();

            if(in_array($domain, $vendor_domains, true)) {
                $this->is_vendor_site = true;
            }
        }

        return $this->is_vendor_site;
    }

    public function getVendorShop()
    {
        if(empty($this->shop)) {
            $domain = parse_url(Request::root())['host'] ?? null;
            $shop_domain = ShopDomain::where('domain', '=', $domain)->first();

            $this->shop = $shop_domain->shop ?? null;
        }

        return $this->shop;
    }

    public function getVendorCategoriesIDs() {
        if(!empty($this->shop) && empty($this->vendor_categories_ids)) {
            // TODO: ID list array with products only by single vendor
            // TODO: Check Models CRUD PAGES!
            // TODO: Remove stock/variations $with and use them only when necessary
            $all_products_ids = $this->shop->products()->without(['stocks', 'variations'])->select('id')->get()->pluck('id')->toArray();
            $this->vendor_categories_ids = CategoryRelationship::where('subject_type', '=', Product::class)->whereIn('subject_id', $all_products_ids)
                ->select('category_id')->get()->pluck('category_id')->unique()->toArray();
        }

        return $this->vendor_categories_ids;
    }
}

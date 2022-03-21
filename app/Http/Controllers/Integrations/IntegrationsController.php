<?php

namespace App\Http\Controllers\Integrations;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CoreMeta;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Upload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use MyShop;
use Str;


class IntegrationsController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.integrations.index');
    }

    public function woocommerce()
    {
        $this->woocommerce_category_import();
        $this->woocommerce_product_import();
    }





}

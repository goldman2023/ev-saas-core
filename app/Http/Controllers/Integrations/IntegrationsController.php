<?php

namespace App\Http\Controllers\Integrations;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\CoreMeta;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use MyShop;

use Codexshaper\WooCommerce\Facades\Product as WooProduct;
use Codexshaper\WooCommerce\Facades\Coupon as WooCoupon;
use Codexshaper\WooCommerce\Facades\Order as WooOrder;
use Exception;
use Illuminate\Support\Facades\Storage;

class IntegrationsController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.integrations.index');
    }

    public function woocommerce()
    {
        // Get all products from woocommerce
        $products = WooProduct::all();

        /* Import all products as models */
        foreach($products as $product) {
            $new_product = Product::create([
                'shop_id' => MyShop::getShopID(),
                'user_id' => auth()->user()->id,
                'name' => $product->name,
                'unit_price' => $product->price,
                'description' => $product->description
            ]);


            /* Handle images */
            /* TODO : add file type handling */
            $featured_image = Storage::disk('local')->put('transfer/' . $product->images[0]->name, file_get_contents($product->images[0]->src));
            dd($featured_image);
            /* Add import meta  */
            try {
                $meta_row = new CoreMeta();
                $meta_row->key = "sales_channel";
                $meta_row->value = "wc";
                $meta_row->subject_id = $new_product->id;
                $meta_row->subject_type = Product::class;
                $meta_row->save();

                $meta_row = new CoreMeta();
                $meta_row->key = "wc_id";
                $meta_row->value = $product->id;
                $meta_row->subject_id = $new_product->id;
                $meta_row->subject_type = Product::class;
                $meta_row->save();
            } catch (Exception $e) {

            }
        }


        dd($products);





        // $product_test = Product::first();

        // $product_test->core_meta;

        dd($product_test->core_meta);

        $coupons = WooCoupon::all();

        $orders = WooOrder::all();
        dd($products);
    }
}

<?php

namespace App\Http\Controllers\Integrations;
use App\Models\CoreMeta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Codexshaper\WooCommerce\Facades\Product as WooProduct;
use Codexshaper\WooCommerce\Facades\Coupon as WooCoupon;
use Codexshaper\WooCommerce\Facades\Order as WooOrder;
use Codexshaper\WooCommerce\Facades\Category as WooCategory;
use Exception;
use Illuminate\Support\Facades\Storage;
use App\Exports\ProductsExport;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Upload;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use MyShop;
use Str;

class WooCommerceController extends Controller
{
    // Get all products from woocommerce
    public $request_options = [
        'per_page' => 50, // By default 10
        'page' => 1 // This is will return 51 to 100 products. By default 1 that returns the 1 to 50 for this example because we add per_page 50
    ];
    //
    public function index()
    {
        /* TODO: Create dedicated index page for woocommerce import options and buttons and api keys setup/oAuth maybe */
    }

    public function import($type)
    {
        switch ($type) {
            case 'categories':
                $this->woocommerce_category_import();
                break;
            case 'products':
                $this->woocommerce_products_import();
                break;
            case 'orders':

                $this->woocommerce_category_import();

                $this->woocommerce_products_import();

                $this->woocommerce_orders_import();
                break;
            default:
                # code...
                break;
        }

        return redirect()->route('integrations.woocommerce.import-results', ['type' => $type]);
    }

    public function woocommerce_products_import()
    {

        $products = WooProduct::all($this->request_options);


        /* Import all products as models */
        foreach ($products as $product) {
            /* Check if this external product is already added */
            if (!CoreMeta::where('key', 'wc_id')->where('value', $product->id)->first()) {
                $new_product = Product::create([
                    'shop_id' => MyShop::getShopID(),
                    'user_id' => auth()->user()->id,
                    'name' => $product->name,
                    'unit_price' => $product->price,
                    'description' => $product->description
                ]);
            } else {
                $new_product = CoreMeta::where('key', 'wc_id')->where('value', $product->id)->first()->subject;
                echo "Updating product with ID" . $new_product->id . "...";
            }

            /* Handle images */
            /* TODO : add file type handling */
            $tenant_path = 'uploads/all';

            if (tenant('id')) {
                $tenant_path = 'uploads/' . tenant('id');
            }

            try {
                $featured_image = Storage::disk('s3')->put($tenant_path . '/' . $product->images[0]->name, file_get_contents($product->images[0]->src), 'public');
                $upload = new Upload();

                $upload->file_original_name = 'labas.png';



                $upload->extension = '.png';
                /* TODO: Fix extension */
                $upload->file_name = $tenant_path . '/' . $product->images[0]->name;
                $upload->user_id = auth()->user()->id;
                $upload->shop_id = empty(MyShop::getShopID()) ? null : MyShop::getShopID();
                $upload->type = 'image';
                $upload->file_size = '99'; // TODO : get file size
                $upload->save();

                $new_product->thumbnail = $upload->id;
                $new_product->syncUploads();
            } catch(Exception $e) {
                return $e;
            }

            $new_product->save();

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
                /* TODO: handle an error if unique key is duplicate */
            }

            /* TODO: add a check for updating/ignoring stock updates */
            if (true) {
                $this->setProductStocks($new_product, $product);
            }
        }
    }

    public function woocommerce_category_import()
    {

        /* Category Importing */
        $categories = WooCategory::all($this->request_options);
        foreach ($categories as $category) {
            if (!Category::where('name', $category->name)->first()) {
                $new_category = new Category();
            } else {
                $new_category = Category::where('name', $category->name)->first();
            }

            $new_category->name = $category->name;
            $new_category->slug = $category->slug;
            if ($category->parent == 0) {
                $new_category->parent_id = null;
            } else {
                $new_category->parent_id = $category->parent;
            }
            $new_category->level = 0;
            $new_category->description = $category->description;
            $new_category->save();


            /* Add import meta  */
            try {
                $meta_row = new CoreMeta();
                $meta_row->key = "sales_channel";
                $meta_row->value = "wc";
                $meta_row->subject_id = $new_category->id;
                $meta_row->subject_type = Category::class;
                $meta_row->save();

                $meta_row = new CoreMeta();
                $meta_row->key = "wc_id";
                $meta_row->value = $new_category->id;
                $meta_row->subject_id = $new_category->id;
                $meta_row->subject_type = Category::class;
                $meta_row->save();
            } catch (Exception $e) {
                /* TODO: handle an error if unique key is duplicate */
            }
        }
    }


    protected function woocommerce_single_order_import($wc_order)
    {
        /* TODO: Create propper mapping and abstraction for creating order */
        /*  $order = new Order();
        $order->shop_id = \CartService::getShop(true);
        $order->user_id = auth()->user()->id ?? null;
        $order->email = $data['email'];
        $order->type = OrderTypeEnum::standard()->value;
        $order->payment_status = $wc_order->status;
        $order->total_price = $wc_order->total; */
    }

    protected function woocommerce_orders_import()
    {
        $orders = WooOrder::all($this->request_options);
        // dd($orders);

        /* Import all products as models */
        foreach ($orders as $order) {
            /* Check if this external product is already added */
            if (CoreMeta::where('key', 'wc_id')->where('value', $order->id)->first()) {
                $order = CoreMeta::where('key', 'wc_id')->where('value', $order->id)->first()->subject;
                echo "Updating order with ID" . $order->id . "...";
            } else {
            }
            $this->woocommerce_single_order_import($order);
        }
    }

    /* TODO: Update this to check if stock is not created on a global scope, not only in product form */
    protected function setProductStocks($product, $wc_product)
    {

        if (empty($wc_product->sku)) {
            $sku = $wc_product->slug;
        } else {
            $sku = $wc_product->sku;
        }
        try {
            $product_stock = ProductStock::firstOrNew(['subject_id' => $product->id, 'subject_type' => Product::class, 'sku' => $sku]);
            $product_stock->sku = empty($wc_product->sku) ? $sku : $wc_product->sku;
            $product_stock->barcode = empty($product->barcode) ? null : $product->barcode;
            $product_stock->qty = empty($wc_product->stock_quantity) ? 1 : $wc_product->stock_quantity;
            $product_stock->low_stock_qty = empty($product->low_stock_qty) ? 1 : $product->low_stock_qty;
            $product_stock->use_serial = ($product->use_serial ?? false) === true;
            $product_stock->allow_out_of_stock_purchases = ($product->allow_out_of_stock_purchases ?? false) === true;
            $product_stock->save();
        } catch (Exception $e) {
            return $e;
        }
    }

    public function import_results($type)
    {
        return view('frontend.dashboard.integrations.woocommerce.import-results');
    }
}

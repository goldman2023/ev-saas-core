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
use App\Models\WeWooImport;
use Codexshaper\WooCommerce\Facades\Category as WooCategory;
use Codexshaper\WooCommerce\Facades\Coupon as WooCoupon;
use Codexshaper\WooCommerce\Facades\Order as WooOrder;
use Codexshaper\WooCommerce\Facades\Product as WooProduct;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use MyShop;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use Str;

class WooCommerceController extends Controller
{
    // Get all products from woocommerce
    public $request_options = [
        'per_page' => 50, // By default 10
        'page' => 1, // This is will return 51 to 100 products. By default 1 that returns the 1 to 50 for this example because we add per_page 50
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
                // code...
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
            if (! CoreMeta::where('key', 'wc_id')->where('value', $product->id)->first()) {
                $new_product = Product::create([
                    'shop_id' => MyShop::getShopID(),
                    'user_id' => auth()->user()->id,
                    'name' => $product->name,
                    'unit_price' => $product->price,
                    'description' => $product->description,
                ]);
            } else {
                $new_product = CoreMeta::where('key', 'wc_id')->where('value', $product->id)->first()->subject;
                echo 'Updating product with ID'.$new_product->id.'...';
            }

            /* Handle images */
            /* TODO : add file type handling */
            $tenant_path = 'uploads/all';

            if (tenant('id')) {
                $tenant_path = 'uploads/'.tenant('id');
            }

            try {
                $featured_image = Storage::disk(config('filesystems.default'))->put($tenant_path.'/'.$product->images[0]->name, file_get_contents($product->images[0]->src), 'public');
                $upload = new Upload();

                $upload->file_original_name = 'labas.png';

                $upload->extension = '.png';
                /* TODO: Fix extension */
                $upload->file_name = $tenant_path.'/'.$product->images[0]->name;
                $upload->user_id = auth()->user()->id;
                $upload->shop_id = empty(MyShop::getShopID()) ? null : MyShop::getShopID();
                $upload->type = 'image';
                $upload->file_size = '99'; // TODO : get file size
                $upload->save();

                $new_product->thumbnail = $upload->id;
                $new_product->syncUploads();
            } catch (Exception $e) {
                return $e;
            }

            $new_product->save();

            /* Add import meta  */
            try {
                $meta_row = new CoreMeta();
                $meta_row->key = 'sales_channel';
                $meta_row->value = 'wc';
                $meta_row->subject_id = $new_product->id;
                $meta_row->subject_type = Product::class;
                $meta_row->save();

                $meta_row = new CoreMeta();
                $meta_row->key = 'wc_id';
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
            if (! Category::where('name', $category->name)->first()) {
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
                $meta_row->key = 'sales_channel';
                $meta_row->value = 'wc';
                $meta_row->subject_id = $new_category->id;
                $meta_row->subject_type = Category::class;
                $meta_row->save();

                $meta_row = new CoreMeta();
                $meta_row->key = 'wc_id';
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
                echo 'Updating order with ID'.$order->id.'...';
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

    public function transfer_woocommerce_produts_to_destination(Request $request, $all = true, $mode = 'export') {

        /* TODO: Wtft is this, session()->save? It's cool I guess :D  */
        session(['import_mode' => 'export']);
        session()->save();

        $destination = 'woo_export';
        $count = 0;
        if($mode == 'export') {
            $products = WeWooImport::where('runs', 0)->get();

            foreach($products as $product) {
                try {
                    $transfer_data = (json_decode($product->data, true));
                    $transfer_data['status'] = 'draft';
                    $product_to_create = WooProduct::create($transfer_data);
                    /* TODO: Send data via rest api to woocommerce */
                    $product->runs++;
                    $product->destination = $destination;
                    $product->save();
                    $count++;
                } catch(Exception $e) {
                    dd($e->getMessage());
                }
            }

        }

        dd($count . "Transfered Products");
    }

    public function transfer_woocommerce_produts($all = true, $mode = 'import') {

        $import_mode = session('import_mode');

        $count = 0;
        if($mode == 'import') {
            $products = WooProduct::all($this->request_options);

            foreach($products as $prooduct) {
                if(WeWooImport::where('source', 'woo_import')->where('refference_id', $prooduct->id)->count() == 0) {
                    $import = new WeWooImport();
                    $import->data = json_encode($prooduct);
                    $import->refference_id = $prooduct->id;
                    $import->source =
                    $import->save();
                    $count++;
                }

            }

        } else {
            $products = WooProduct::all($this->request_options);

        }

        dd($count . " Products Imported For Transfer");




        $data = [
            'name' => 'Variable Product',
            'type' => 'variable',
            'description' => 'Variable product full description.',
            'short_description' => 'Variable product short description.',
            'categories' => [
                [
                  'id' => 1
                ],
                [
                  'id' => 3
                ],
                [
                  'id' => 5
                ]
            ],
            'images' => [
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_4_back.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_front.jpg'
                ],
                [
                    'src' => 'http://demo.woothemes.com/woocommerce/wp-content/uploads/sites/56/2013/06/T_3_back.jpg'
                ]
            ],
            'attributes' => [
                [
                    'id' => 6,
                    'position' => 0,
                    'visible' => false,
                    'variation' => true,
                    'options' => [
                        'Black',
                        'Green'
                    ]
                ],
                [
                    'name' => 'Size',
                    'position' => 0,
                    'visible' => true,
                    'variation' => true,
                    'options' => [
                        'S',
                        'M'
                    ]
                ]
            ],
            'default_attributes' => [
                [
                    'id' => 6,
                    'option' => 'Black'
                ],
                [
                    'name' => 'Size',
                    'option' => 'S'
                ]
            ]
        ];

        $product = Product::create($data);
    }
}

<?php

namespace App\Http\Controllers\Integrations;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CoreMeta;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Upload;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;
use MyShop;
use Str;

use Codexshaper\WooCommerce\Facades\Product as WooProduct;
use Codexshaper\WooCommerce\Facades\Coupon as WooCoupon;
use Codexshaper\WooCommerce\Facades\Order as WooOrder;
use Codexshaper\WooCommerce\Facades\Category as WooCategory;
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
        $this->woocommerce_category_import();
        $this->woocommerce_product_import();





    }

    public function woocommerce_product_import() {
          // Get all products from woocommerce
          $products = WooProduct::all();


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
              if(true) {
                  $this->setProductStocks($new_product, $product);
              }
          }
    }

    public function woocommerce_category_import() {

        /* Category Importing */
        $categories = WooCategory::all();
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


    /* TODO: Update this to check if stock is not created on a global scope, not only in product form */
    protected function setProductStocks($product, $wc_product) {
        $product_stock = ProductStock::firstOrNew(['subject_id' => $product->id, 'subject_type' => Product::class]);
        $product_stock->sku = empty($wc_product->sku) ? Str::slug($wc_product->name) : $wc_product->sku;
        $product_stock->barcode = empty($product->barcode) ? null : $product->barcode ;
        $product_stock->qty = empty($wc_product->stock_quantity) ? 1 : $wc_product->stock_quantity;
        $product_stock->low_stock_qty = empty($product->low_stock_qty) ? 1 : $product->low_stock_qty;
        $product_stock->use_serial = ($product->use_serial ?? false) === true;
        $product_stock->allow_out_of_stock_purchases = ($product->allow_out_of_stock_purchases ?? false) === true;
        $product_stock->save();
    }
}

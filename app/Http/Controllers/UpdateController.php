<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use URL;
use DB;
use Artisan;
use Schema;
use App\Models\BusinessSetting;
use App\Models\Language;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Brand;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\SubCategoryTranslation;
use App\Models\SubSubCategoryTranslation;
use App\Models\Attribute;
use App\Models\ProductStock;
use App\Models\Upload;
use App\Models\Banner;
use App\Models\User;
use App\Models\CustomerPackage;
use App\Models\CustomerProduct;
use App\Models\FlashDeal;
use App\Models\Product;
use App\Models\Tax;
use App\Models\ProductTax;
use App\Models\Shop;
use App\Models\Slider;
use App\Models\HomeCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use Storage;
use ZipArchive;

class UpdateController extends Controller
{
    public function step0(Request $request) {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('This action is disabled in demo mode'))->error();
            return back();
        }
        if ($request->hasFile('update_zip')) {
            if (class_exists('ZipArchive')) {
                // Create update directory.
                $dir = 'updates';
                if (!is_dir($dir))
                    mkdir($dir, 0777, true);

                $path = Storage::disk('local')->put('updates', $request->update_zip);

                $zipped_file_name = $request->update_zip->getClientOriginalName();

                //Unzip uploaded update file and remove zip file.
                $zip = new ZipArchive;
                $res = $zip->open(base_path('public/' . $path));

                if ($res === true) {
                    $res = $zip->extractTo(base_path());
                    $zip->close();
                } else {
                    flash(translate('Could not open the updates zip file.'))->error();
                    return back();
                }

                return redirect()->route('update.step1');
            }
            else {
                flash(translate('Please enable ZipArchive extension.'))->error();
            }
        }
        else {
            return view('update.step0');
        }
    }

    public function step1() {
        if(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '4.2'){
            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '4.1'){
            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '4.0'){
            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '3.9'){
            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '3.8'){
            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '3.7'){
            $sql_path = base_path('sqlupdates/v38.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        elseif(BusinessSetting::where('type', 'current_version')->first() != null && BusinessSetting::where('type', 'current_version')->first()->value == '3.6'){
            $sql_path = base_path('sqlupdates/v37.sql');
            DB::unprepared(file_get_contents($sql_path));

            $this->convertCategory();

            $sql_path = base_path('sqlupdates/v38.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v39.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v40.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v41.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v42.sql');
            DB::unprepared(file_get_contents($sql_path));

            $sql_path = base_path('sqlupdates/v43.sql');
            DB::unprepared(file_get_contents($sql_path));

            return redirect()->route('update.step2');
        }
        else {
            Artisan::call('view:clear');
            Artisan::call('cache:clear');
            $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
            $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
            copy($newRouteServiceProvier, $previousRouteServiceProvier);

            return view('update.done');
        }
    }

    public function step2() {
        if(count(ProductTax::all()) == 0){
            $this->convertTaxes();
        }

        foreach (Order::all() as $order) {
            if (count($order->orderDetails) > 0) {
                $order->seller_id = $order->orderDetails->first()->seller_id;
                $order->delivery_status = $order->orderDetails->first()->delivery_status;
                $order->save();
            }
        }

        Artisan::call('view:clear');
        Artisan::call('cache:clear');
        $previousRouteServiceProvier = base_path('app/Providers/RouteServiceProvider.php');
        $newRouteServiceProvier      = base_path('app/Providers/RouteServiceProvider.txt');
        copy($newRouteServiceProvier, $previousRouteServiceProvier);

        return view('update.done');
    }

    public function convertTaxes(){
        $tax = Tax::first();

        foreach (Product::all() as $product) {
            $product_tax = new ProductTax;
            $product_tax->product_id = $product->id;
            $product_tax->tax_id = $tax->id;
            $product_tax->tax = $product->tax;
            $product_tax->tax_type = $product->tax_type;
            $product_tax->save();
        }
    }

    public function convertCategory(){
        foreach (SubCategory::all() as $key => $value) {
            $category = new Category;
            $parent = Category::find($value->category_id);

            $category->name = $value->name;
            $category->digital = $parent->digital;
            $category->banner = null;
            $category->icon = null;
            $category->meta_title = $value->meta_title;
            $category->meta_description = $value->meta_description;

            $category->parent_id = $parent->id;
            $category->level = $parent->level + 1;
            $category->slug = $value->slug;
            $category->commision_rate = $parent->commision_rate;

            $category->save();

            foreach (SubCategoryTranslation::where('sub_category_id', $value->id)->get() as $translation) {
                $category_translation = new CategoryTranslation;
                $category_translation->category_id = $category->id;
                $category_translation->lang = $translation->lang;
                $category_translation->name = $translation->name;
                $category_translation->save();
            }
        }

        foreach (SubSubCategory::all() as $key => $value) {
            $category = new Category;
            $parent = Category::find(Category::where('name', SubCategory::find($value->sub_category_id)->name)->first()->id);

            $category->name = $value->name;
            $category->digital = $parent->digital;
            $category->banner = null;
            $category->icon = null;
            $category->meta_title = $value->meta_title;
            $category->meta_description = $value->meta_description;

            $category->parent_id = $parent->id;
            $category->level = $parent->level + 1;
            $category->slug = $value->slug;
            $category->commision_rate = $parent->commision_rate;

            $category->save();

            foreach (SubSubCategoryTranslation::where('sub_sub_category_id', $value->id)->get() as $translation) {
                $category_translation = new CategoryTranslation;
                $category_translation->category_id = $category->id;
                $category_translation->lang = $translation->lang;
                $category_translation->name = $translation->name;
                $category_translation->save();
            }
        }

        foreach (Product::all() as $key => $value) {
            try{
                if ($value->subsubcategory_id == null) {
                    $value->category_id = Category::where('name', SubCategory::find($value->subcategory_id)->name)->first()->id;
                    $value->save();
                }
                else {
                    $value->category_id = Category::where('name', SubSubCategory::find($value->subsubcategory_id)->name)->first()->id;
                    $value->save();
                }
            }
            catch(\Exception $e){

            }
        }

        foreach (CustomerProduct::all() as $key => $value) {
            try{
                if ($value->subsubcategory_id == null) {
                    $value->category_id = Category::where('name', SubCategory::find($value->subcategory_id)->name)->first()->id;
                    $value->save();
                }
                else {
                    $value->category_id = Category::where('name', SubSubCategory::find($value->subsubcategory_id)->name)->first()->id;
                    $value->save();
                }
            }
            catch(\Exception $e){

            }
        }
    }
}

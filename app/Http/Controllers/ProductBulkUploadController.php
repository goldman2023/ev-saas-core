<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use App\Models\Brand;
use App\Models\User;
use Auth;
use App\Models\ProductsImport;
use App\Models\ProductsExport;
use PDF;
use Excel;
use Illuminate\Support\Str;

class ProductBulkUploadController extends Controller
{
    public function index()
    {
        if (auth()->user()->isSeller()) {
            return view('frontend.user.seller.product_bulk_upload.index');
        }
        elseif (auth()->user()->isAdmin() || auth()->user()->isStaff()) {
            return view('backend.product.bulk_upload.index');
        }
    }

    public function export(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }

    public function pdf_download_category()
    {
        $categories = Category::all();

        return PDF::loadView('backend.downloads.category',[
            'categories' => $categories,
        ], [], [])->download('category.pdf');
    }

    public function pdf_download_brand()
    {
        $brands = Brand::all();

        return PDF::loadView('backend.downloads.brand',[
            'brands' => $brands,
        ], [], [])->download('brands.pdf');
    }

    public function pdf_download_seller()
    {
        $users = User::where('user_type','seller')->get();

        return PDF::loadView('backend.downloads.user',[
            'users' => $users,
        ], [], [])->download('user.pdf');

    }

    public function bulk_upload(Request $request)
    {
        if($request->hasFile('bulk_file')){
            Excel::import(new ProductsImport, request()->file('bulk_file'));
        }
        flash(translate('Products imported successfully'))->success();
        return back();
    }

}

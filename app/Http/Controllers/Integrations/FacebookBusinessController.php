<?php

namespace App\Http\Controllers\Integrations;

use App\Exports\ProductsExportFacebookBasic;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;


class FacebookBusinessController extends Controller
{
    public function export()
    {
        return Excel::download((new ProductsExportFacebookBasic), 'products.csv');

    }

    public function success() {
        echo "success;";
    }
}

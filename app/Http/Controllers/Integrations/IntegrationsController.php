<?php

namespace App\Http\Controllers\Integrations;

use App\Exports\ProductsExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Newsletter\NewsletterFacade as Newsletter;


class IntegrationsController extends Controller
{
    public function index()
    {
        return view('frontend.dashboard.integrations.index');
    }
}

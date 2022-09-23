<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PixProLicenseController extends Controller
{
    //

    public function index()
    {

    }

    public function licenses_index() {
        return view('frontend.dashboard.crm.licenses.index', );

    }
}

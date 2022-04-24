<?php

namespace App\Http\Controllers\Integrations;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PixProLicenseController extends Controller
{
    //

    public function index()
    {
        // Requires main config
        require_once 'config.php';
        $api          = new Pixpro_API();
        dd("labas");
    }
}

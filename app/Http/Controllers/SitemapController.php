<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Sitemap\SitemapGenerator;

class SitemapController extends Controller
{
    //
    public function generate() {
        $domain = 'http://pix.ev-saas.localhost:8000/';
        SitemapGenerator::create($domain)->writeToFile( public_path(). '/sitemap.xml');

    }
}

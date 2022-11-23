<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{

    public function display()
    {
        $sitemap = Storage::disk('public')->get('/sitemap.xml');
        return Response::make($sitemap, '200')->header('Content-Type', 'text/xml');
    }
    //
    public function generate()
    {
        $sitemap =  Sitemap::create()
            ->add(Page::all())
            ->add(BlogPost::all())
            ->writeToDisk('public', 'sitemap.xml');

        echo "Sitemap Updated Sucesfully";
    }
}

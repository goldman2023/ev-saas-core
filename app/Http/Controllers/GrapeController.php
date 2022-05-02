<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class GrapeController extends Controller
{
    //

    public function index() {

        $page = null;

        $sections = File::allFiles(public_path() . '/tailwindui/components/ecommerce/');
        $content = "";

        foreach($sections as $section) {
            // dd(file_get_contents($section->getPathName()));
            // dd($section);
        }

        // Remove unwanted HTML comments


        return view('grape.index', [
            'content' => $content,
            'sections' => $sections,
        ]);
    }
}

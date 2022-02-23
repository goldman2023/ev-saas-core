<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class WeEditController extends Controller
{
    //
    public function index() {
        return view('we-edit.index');
    }

    public function flow() {
        $pages = Page::all();
        $positions['x'] = 0;
        $positions['y'] = 200;
        $count = 0;
        foreach($pages as $page ) {
            $count++;
            $page['data'] = ['label' => $page->title];
            $page->type = 'default';
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $pages = json_encode($pages);
        return view('we-edit.flow', compact('pages'));
    }
}

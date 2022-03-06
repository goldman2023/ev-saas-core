<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class WeEditController extends Controller
{
    //
    public function index()
    {
        return view('we-edit.index');
    }

    public function grapejs_index()
    {
        return view('we-edit.grapejs-index');
    }

    public function flow()
    {
        $pages = Page::all();
        $positions['x'] = 0;
        $positions['y'] = 200;
        $count = 0;
        foreach ($pages as $page) {
            $count++;
            $page['data'] = ['label' => $page->title];
            $page->type = 'wenode';
            $page->key = 'key_' . $count;
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $menu_flow = [];
        $available_pages = [];
        $weEditData = [
            'pages' => json_encode($pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow)
        ];

        return view(
            'we-edit.flow',
            [
                'weEditData' => $weEditData
            ]
        );
    }

    public function menuFlow()
    {
        $available_pages = Page::all();
        $positions['x'] = 0;
        $positions['y'] = 200;
        $count = 0;
        foreach ($available_pages as $page) {
            $count++;
            $page['data'] = ['label' => $page->title];
            $page->type = 'wenode';
            $page->key = 'key_' . $count;
            $page->type = 'system';
            $page['position'] = ['x' =>  $positions['x'], 'y' => $positions['y']];
            $positions['x'] += 200;
        }
        $menu_flow = [];

        $pages = [];


        $weEditData = [
            'pages' => json_encode($pages),
            'available_pages' => json_encode($available_pages),
            'menu_flow' => json_encode($menu_flow)
        ];
        return view(
            'we-edit.flow',
            [
                'weEditData' => $weEditData
            ]
        );
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;

class GrapeController extends Controller
{
    //

    public function index($pageID = 7) {

        if($pageID) {
            $page_html =  Page::findOrFail($pageID)->content;
        } else {
            $page_html = "";
        }

        if(is_array($page_html)) {
            $page_html = json_encode($page_html);
        }

        $sections = Section::all();
        $content = $page_html;

        return view('grape.index', [
            'pageID' => $pageID,
            'content' => $content,
            'type' => 'page',
            'sections' => $sections,
        ]);
    }

    public function edit_section($sectionID) {
        if($sectionID) {
            $page_html =  Section::findOrFail($sectionID)->html_blade;
        } else {
            $page_html = "";
        }


        if(is_array($page_html)) {
            $page_html = json_encode($page_html);
        }



        $sections = [];

        $sections = Section::all();
        $content = $page_html;

        // foreach($sections as $section) {
        //     // dd(file_get_contents($section->getPathName()));
        //     // dd($section);
        // }

        // Remove unwanted HTML comments


        return view('grape.index', [
            'pageID' => $sectionID,
            'type' => 'section',
            'content' => $content,
            'sections' => $sections,
        ]);
    }

    public function save_custom_html(Request $request, $pageID, $type) {
        if($type == 'page') {
            $page =  Page::findOrFail($pageID);

            $page->content = $request->custom_html;

            $page->save();
        }

        if($type == 'section') {
            $page =  Section::findOrFail($pageID);

            $page->html_blade = $request->custom_html;

            $page->save();
        }


        return redirect()->back();

    }


    public function pageBuilder() {

    }
}

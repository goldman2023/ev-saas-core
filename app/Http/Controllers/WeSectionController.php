<?php

namespace App\Http\Controllers;

use Cookie;
use MyShop;
use Session;
use Categories;
use Permissions;
use App\Models\Section;
use Illuminate\Http\Request;

class WeSectionController extends Controller
{
    public function index(Request $request)
    {
        $sections = Section::all();

        return view('frontend.dashboard.sections.index', compact('sections'));
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.sections.create');
    }

    public function edit(Request $request, $id)
    {
        $section = Section::findOrFail($id);

        return view('frontend.dashboard.sections.edit', compact('section'));
    }

    public function preview(Request $request, $id)
    {
        $section = Section::findOrFail($id);
        // $section_content = \WeEngine::twig()->render(Section::class.'|'.$id, []);
        $section_content = $section->html_blade;

        return view('frontend.dashboard.sections.preview', compact('section', 'section_content'));
    }
}

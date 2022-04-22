<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KnowledgeBaseController extends Controller
{
    //

    public function index()
    {
        return view('frontend.knowledge-base.index');
    }

    public function archive()
    {
        return view('frontend.knowledge-base.archive');
    }

    public function show()
    {
        return view('frontend.knowledge-base.show');
    }
}

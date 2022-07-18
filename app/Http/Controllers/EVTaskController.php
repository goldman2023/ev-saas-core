<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EVTaskController extends Controller
{
    public function index(){

        return view('frontend.dashboard.tasks.index');
    }

    public function edit(){

        return view('frontend.dashboard.tasks.edit');
    }

    public function create(){

        return view('frontend.dashboard.tasks.create');
    }

    public function destroy($id){

        return view('frontend.dashboard.tasks.destroy');
    }
    
    public function details($id){

        return view('frontend.dashboard.tasks.details');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use MyShop;

class EVTaskController extends Controller
{

    public function index(Request $request){
        $tasks = Task::all();
        return view('frontend.dashboard.tasks.index',compact('tasks'));
    }

    public function edit(Request $request, $id){
        $task = Task::findOrFail($id);
        return view('frontend.dashboard.tasks.edit',compact('task'));
    }

    public function create(Request $request){

        return view('frontend.dashboard.tasks.create');
    }

    public function destroy(Request $request, $id){

        return view('frontend.dashboard.tasks.destroy');
    }
    
    public function details(Request $request, $id){
        $task = Task::findOrFail($id);
        return view('frontend.dashboard.tasks.details',compact('task'));
    }
}

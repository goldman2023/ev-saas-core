<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use MyShop;
use DB;

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
        $is_deleted = DB::delete('delete from tasks where id = ?',[$id]);
        if($is_deleted){
            return redirect()->route('tasks.index');
        }
        else{
            $this->inform(translate('There was an error deleting a task...Please try again.'), '', 'fail');
        }
    }
    
    public function details(Request $request, $id){
        $task = Task::findOrFail($id);
        return view('frontend.dashboard.tasks.details',compact('task'));
    }

    public function completed(Request $request, $id){

        DB::update('update tasks set status="done" where id = ?',[$id]);
        return back();
    }
}

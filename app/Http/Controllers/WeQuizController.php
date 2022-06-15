<?php

namespace App\Http\Controllers;

use App\Models\WeQuiz;
use Illuminate\Http\Request;

class WeQuizController extends Controller
{
    //

    public function index() {
        $quizes = WeQuiz::all();
        return view('frontend.we-quiz.index', compact('quizes'));
    }


    public function show($quiz_id) {
        $quiz = WeQuiz::findOrFail($quiz_id);
        return view('frontend.we-quiz.show', compact('quiz') );
    }

    public function create() {
        return view('frontend.we-quiz.create');
    }

    public function save_result(Request $request, $id) {
        $quiz = WeQuiz::findOrFail($id);

        return response()->json($quiz);    
    }
}

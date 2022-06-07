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
}

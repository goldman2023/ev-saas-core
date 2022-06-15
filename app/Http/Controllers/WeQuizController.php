<?php

namespace App\Http\Controllers;

use App\Models\WeQuiz;
use App\Models\WeQuizResult;
use Illuminate\Http\Request;
use App\Exceptions\WeAPIException;

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

        $results_data = $request->json()->all();

        if (count($results_data) > 0 && !empty($results_data['user_id'] ?? null) && !empty($results_data['answers'] ?? null)) {
            $quiz->results()->create([
                'user_id' => $results_data['user_id'],
                'quiz_answers' => $results_data['answers']
            ]);

            return response()->json($quiz->results()->where('user_id', $results_data['user_id'])->first());
        }

    
        throw new WeAPIException(message: translate('Could not save quiz results'), type: 'WeApiException', code: 400);
    }
}

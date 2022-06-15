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
        return view('frontend.dashboard.we-quiz.index', compact('quizes'));
    }


    public function show($quiz_id) {
        $quiz = WeQuiz::findOrFail($quiz_id);
        return view('frontend.we-quiz.show', compact('quiz') );
    }

    public function create() {
        return view('frontend.dashboard.we-quiz.create');
    }

    public function edit(Request $request, $id) {
        $quiz = WeQuiz::findOrFail($id);
        return view('frontend.dashboard.we-quiz.edit', compact('quiz'));
    }

    public function save_quiz(Request $request, $id = null) {
        $results_data = $request->json()->all();

        if (count($results_data) > 0 && !empty($results_data['user_id'] ?? null) && !empty($results_data['quiz_json'] ?? null)) {
            if(empty($id)) {
                // Create
                $quiz = new WeQuiz();
                $quiz->user_id = $results_data['user_id'];
                $quiz->name = $results_data['quiz_json']['title'] ?? 'Quiz';
                $quiz->quiz_json = $results_data['quiz_json'];
                $quiz->save();
            } else {
                // Update
                $quiz = WeQuiz::findOrFail($id);
                $quiz->name = $results_data['quiz_json']['title'] ?? 'Quiz';
                $quiz->quiz_json = $results_data['quiz_json'];
                $quiz->save();
            }

            return response()->json($quiz);
        }

    
        throw new WeAPIException(message: translate('Could not save quiz'), type: 'WeApiException', code: 400);
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

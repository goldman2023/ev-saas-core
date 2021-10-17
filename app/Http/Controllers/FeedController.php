<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class FeedController extends Controller
{
    //

    public function index() {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(10);

        return view('frontend.feed.index', compact('activities'));
    }
}

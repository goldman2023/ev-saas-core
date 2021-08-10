<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\AttributeRelationship;
use App\Models\AttributeValue;
use App\Models\Shop;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use function foo\func;

class ActivityController extends Controller
{

    /**
     * Display a listing of all users activities
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(10);
        return view('backend.activities.index', compact('activities'));
    }

    /**
     * Display a list of the current authenticated user activities
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function user_activity()
    {
        $activities = Activity::where('causer_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(10);
        return view('backend.activities.index', compact('activities'));
    }
}

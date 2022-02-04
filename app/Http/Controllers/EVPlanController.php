<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\BlogPost;
use App\Models\Plan;
use MyShop;
use Illuminate\Http\Request;
use Permissions;
use Session;
use Cookie;
use Categories;

class EVPlanController extends Controller
{
    public function index(Request $request) {
        $plans = Plan::all();

        return view('frontend.dashboard.plans.index', compact('plans'));
    }

    public function create(Request $request) {
        return view('frontend.dashboard.plans.create');
    }

    public function edit(Request $request, $slug) {
        $plan = Plan::where('slug', $slug)->first();

        return view('frontend.dashboard.plans.edit', compact('plan'));
    }

}

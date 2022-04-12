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

    public function edit(Request $request, $id) {
        $plan = Plan::findOrFail($id);

        return view('frontend.dashboard.plans.edit', compact('plan'));
    }

    public function my_plans_management(Request $request) {
        $plans = Plan::all();
        
        return view('frontend.dashboard.plans.plans-management', compact('plans'));
    }
}

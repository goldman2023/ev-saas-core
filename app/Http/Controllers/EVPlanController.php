<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Models\BlogPost;
use App\Models\Plan;
use Categories;
use Cookie;
use Illuminate\Http\Request;
use MyShop;
use Permissions;
use Session;

class EVPlanController extends Controller
{
    public function index(Request $request)
    {
        $plans = Plan::all();

        return view('frontend.dashboard.plans.index', compact('plans'));
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.plans.create');
    }

    public function edit(Request $request, $id)
    {
        $plan = Plan::findOrFail($id);

        return view('frontend.dashboard.plans.edit', compact('plan'));
    }

    public function my_plans_management(Request $request)
    {
        $plans = Plan::all();

        return view('frontend.dashboard.plans.plans-management', compact('plans'));
    }

    public function show(Request $request, $slug)
    {
        if (! empty(Plan::where('slug', $slug)->published()->first())) {
            $plan = Plan::where('slug', $slug)->published()->first()->load(['shop']);
        } else {
            return abort(404);
        }

        if (empty($plan->shop)) {
            /* TODO: Default value for products with no shops falls back to shop_id 1 */
            $plan->shop = Shop::first();
        }

        if (auth()->check()) {
            $user = auth()->user();
        } else {
            $user = null;
        }

        activity()
            ->performedOn($plan)
            ->causedBy($user)
            ->withProperties([
                'action' => 'viewed',
                'action_title' => 'Viewed a plan',
            ])
            ->log('viewed');
        /* TODO: Make this optional (style1/style2/etc) per tenant/vendor */

        $template = 'plan-single-1';

        return view('frontend.plan.single.'.$template, compact('plan'));
    }

    public function createPlanCheckoutRedirect($id)
    {
        $plan = Plan::find($id);
        $qty = ! empty(request()->qty ?? null) ? (int) request()->qty : 1;

        $link = StripeService::createCheckoutLink($plan, $qty);

        return redirect($link);
    }
}

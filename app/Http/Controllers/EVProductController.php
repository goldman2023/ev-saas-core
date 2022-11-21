<?php

namespace App\Http\Controllers;

use EVS;
use Auth;
use Stripe;
use Categories;
use App\Models\Shop;
use App\Facades\MyShop;
use App\Models\Product;
use App\Models\CourseItem;
use App\Models\ProductAddon;
use Illuminate\Http\Request;
use App\Enums\CourseItemTypes;
use App\Enums\ProductTypeEnum;
use App\Facades\StripeService;
use Illuminate\Support\Facades\Gate;
use Spatie\Activitylog\Models\Activity;
use Laravel\Nova\Notifications\NovaNotification;

class EVProductController extends Controller
{
    //
    public function index(Request $request)
    {
        if (Auth::user()->user_type == 'admin') {
            $products = Product::orderBy('created_at', 'desc')->paginate(20);
        } else {
            $products = Auth::user()->products()->orderBy('created_at', 'desc')->paginate(20);
        }

        return view('frontend.dashboard.products.index')->with('products', $products);
    }

    public function create(Request $request)
    {
        return view('frontend.dashboard.products.create');
    }

    public function create2(Request $request)
    {
        /* Check if user has shop */
        if (!MyShop::getShop()) {
            /* If not, redirect to shop creation */
            return redirect()->route('onboarding.step3');
        }

        return view('frontend.dashboard.products.create2');
    }

     /* TODO: Add middleware for owner */
     public function edit_course(Request $request, $id)
     {
         $product = Product::findOrFail($id);

         return view('frontend.dashboard.products.edit_course')->with('product', $product);
     }

    /* TODO: Add middleware for owner */
    public function edit(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.edit')->with('product', $product);
    }

    public function edit_stocks(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product) {
            $product->convertUploadModelsToIDs();
        }

        return view('frontend.dashboard.products.stocks')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function edit_variations(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.variations')
            ->with('product', $product)
            ->with('variations_attributes', $product->variant_attributes());
    }

    public function product_details(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.details')->with('product', $product);
    }

    public function product_activity(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $activity = Activity::all();

        $activity = Activity::whereHas('subject')->where('subject_type', \App\Models\Product::class)->where('subject_id', $product->id)->first();

        return view('frontend.dashboard.products.activity')->with('product', $product);
    }

    public function thank_you_preview(Request $request, $id) {
        $product = Product::findOrFail($id);

        return view('frontend.dashboard.products.thank-you-preview')->with('product', $product);
    }

    // Frontend
    public function productsByCategory(Request $request, $slug = null)
    {
        if($slug) {
            $selected_category = Categories::getAll(true)->get(Categories::getCategorySlugFromRoute($slug));
            $products = $selected_category->products()->orderBy('created_at', 'DESC')->paginate(10);
            $shops = $selected_category->shops()->orderBy('created_at', 'DESC')->paginate(10);
        } else {
            $products = Product::orderBy('created_at', 'DESC')->paginate(10);
            $shops = [];
            $selected_category = "";
        }


        // TODO: Init Filters here

        // TODO: return view

        //        $selected_categories = Category::where('slug', $category_slug)->with('children')->get();
        //        if (!empty($selected_categories) && $selected_categories->isNotEmpty()) {
        //            return $this->search($request, $selected_categories);
        //        }
        //
        //        abort(404); // TODO: Maybe a redirect to All Categories?
        //        return null;
        return view('frontend.products.archive', compact('products', 'shops', 'selected_category'));
    }

    public function show(Request $request, $slug)
    {
        /* TODO This is duplicate for consistent naming, let's refactor to better approach */
        if (Product::where('slug', $slug)->exists()) {
            $product = Product::where('slug', $slug)->first()->load(['shop']);
        } else {
            return abort(404);
        }

        //        dd($product->custom_attributes);
        if (empty($product->shop)) {
            /* TODO: Default value for products with no shops falls back to shop_id 1 */
            $product->shop = Shop::first();
        }

        /* TODO: add this eventually: && $product->published */
        if (!empty($product)) {
            if (auth()->check()) {
                $user = auth()->user();
            } else {
                $user = null;
            }

            if($user) {
                activity()
                ->performedOn($product)
                ->causedBy($user)
                ->withProperties([
                    'action' => 'viewed',
                    'action_title' => 'Viewed a product',
                ])
                ->log('viewed');

              /*   $request->user()->notify(
                    NovaNotification::make()
                        ->message('Product was viewed.')
                        ->action('Product', $product->getPermalink())
                        ->icon('View')
                        ->type('info')
                ); */
            }

        }
        /* TODO: Make this optional (style1/style2/etc) per tenant/vendor */

        if($product->type === ProductTypeEnum::course()->value) {

            $template = 'product-course-single';
            $data = [
                'product' => $product,
                'course_items' => $product->course_items->toTree()->filter(fn($item) => $item->parent_id === null),
            ];
        } else {
            $template = 'product-single-1';
            $data = [
                'product' => $product,
                'relatedProducts' => [],
            ];
        }




        return view('frontend.product.single.' . $template, $data);
    }

    public function course_item_show(Request $request, $product_slug, $slug) {
        if (Product::where('slug', $product_slug)->exists()) {
            $product = Product::where('slug', $product_slug)->first()->load(['shop']);
        } else {
            return abort(404);
        }

        if (CourseItem::where('slug', $slug)->exists()) {
            $course_item = CourseItem::where('slug', $slug)->first();
        } else {
            return abort(404);
        }


        // Check if Course item is free or product owned by user
        if($course_item->free || (Auth::check() && ((auth()->user()?->bought($product) ?? false) || (auth()->user()?->manages($product) ?? false)))) {
            $data = [
                'product' => $product,
                'course_items' => $product->course_items->toTree()->filter(fn($item) => $item->parent_id === null),
                'course_item' => $course_item,
                'active_course_item' => $course_item,
            ];

            if($course_item->type === CourseItemTypes::quizz()->value) {
                $quiz_result = $course_item->subject->results()->where('user_id', auth()?->user()?->id)->first();
                $data['quiz_result'] = $quiz_result;
            }


            if(auth()->user()) {
                activity()
                ->performedOn($course_item)
                ->causedBy(auth()->user())
                ->withProperties([
                    'action' => 'viewed',
                ])
                ->log('viewed');
            }

            return view('frontend.product.single.product-course-item-single', $data);
        }

        return redirect()->route(Product::getRouteName(), $product_slug);
    }

    public function show_unlockable_content(Request $request, $slug)
    {
        /* TODO This is duplicate for consistent naming, let's refactor to better approach */
        if (Product::where('slug', $slug)->first()) {
            $product = Product::where('slug', $slug)->first()->load(['shop']);
        } else {
            return abort(404);
        }
        if(auth()->user()) {
            activity()
            ->performedOn($product)
            ->causedBy(auth()->user())
            ->withProperties([
                'action' => 'viewed',
                'action_title' => 'Viewed a purchased content',
            ])
            ->log('viewed');



        }


        return view('frontend.product.single.protected-content', compact('product'));
    }

    public function createProductCheckoutRedirect($id)
    {
        $product = Product::find($id);
        $qty = !empty(request()->qty ?? null) ? (int) request()->qty : 1;

        $link = StripeService::createCheckoutLink($product, $qty);

        return redirect($link);
    }


    // API routes
    public function api_search_products(Request $request) {
        if(auth()->user()->isAdmin()) {
            $q = $request->q;

            $results = Product::published()->search($q)->get();

            // TODO: Return this as an API RESOURCE!
            return response()->json([
                'status' => 'success',
                'results' => $results
            ]);
        }

        throw new WeAPIException(message: translate('Cannot search products if not admin or moderator'), type: 'WeApiException', code: 403);
    }

    public function api_search_product_addons(Request $request) {
        if(auth()->user()->isAdmin()) {
            $q = $request->q;

            $results = ProductAddon::published()->search($q)->get();

            // TODO: Return this as an API RESOURCE!
            return response()->json([
                'status' => 'success',
                'results' => $results
            ]);
        }

        throw new WeAPIException(message: translate('Cannot search product addons if not admin or moderator'), type: 'WeApiException', code: 403);
    }

}

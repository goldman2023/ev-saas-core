<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\ReviewRelationship;
use App\Models\Shop;
use App\Models\Product;
use Auth;
use DB;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $content_type = $request->content_type;
        if ($content_type == 'all') {
            $reviews = Review::orderBy('created_at', 'desc')->paginate(15);
        } else if ($content_type) {
            $reviews = Review::where('content_type', $content_type)->orderBy('created_at', 'desc')->paginate(15);
        } else $reviews = Review::orderBy('created_at', 'desc')->paginate(15);
        return view('backend.reviews.index', compact('reviews', 'content_type'));
    }


    public function seller_reviews()
    {
        $seller = auth()->user()->seller;
        if ($seller == null) abort(404);
        $review_relationships = $seller->reviews()->orderBy('created_at', 'desc')->paginate(15);

        if ($review_relationships != null) {
            foreach ($review_relationships as $relationship) {
                $review = $relationship->review;
                $review->viewed = 1;
                $review->save();
            }
        }

        return view('frontend.user.seller.reviews', compact('review_relationships'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_name)
    {
        $company = Shop::where('slug', 'like', $company_name)->first();
        if ($company == null) abort(404);
        $content_type = 'App\Models\Shop';
        return view('frontend.reviews.create', compact('company_name', 'content_type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = new Review;
        $review->comment = $request->comment;
        $review->rating = $request->rating;
        $review->content_type = $request->content_type;
        $review_relationship = new ReviewRelationship;
        $review->status = 0;
        $review->save();
        $review_relationship->review()->associate($review);
        $company = null;
        if ($request->content_type == 'App\Models\Shop') {
            $company = Shop::where('slug', $request->company_name)->first();
        }
        if ($company == null) {
            $review->delete();
            flash(translate('Unable to find the company.'))->error();
            return back();
        }

        $review_relationship->reviewable()->associate($company);
        $review_relationship->creator()->associate(auth()->user());
        $review_relationship->save();
        flash(translate('Review has been created successfully.'))->success();
        return redirect()->route('shop.sub-page', [$request->company_name, 'reviews']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function updatePublished(Request $request)
    {
        $review = Review::findOrFail($request->id);
        $review->status = $request->status;
        if($review->save()){
            return 1;
        }
        return 0;
    }
}

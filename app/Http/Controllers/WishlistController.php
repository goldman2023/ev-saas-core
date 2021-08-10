<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Wishlist;
use App\Models\Category;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->paginate(9);
        return view('frontend.user.view_wishlist', compact('wishlists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id)
    {
        if(Auth::check()){
            $wishlist = Wishlist::where('user_id', auth()->user()->id)->where('product_id', $id)->first();

            if($wishlist == null){
                $wishlist = new Wishlist;
                $wishlist->user_id = auth()->user()->id;
                $wishlist->product_id = $id;
                $wishlist->save();
            }

            return view('frontend.partials.wishlist');
        }

        return 0;
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
        $wishlist = Wishlist::where('user_id', auth()->user()->id)->findOrFail($id);

        if($wishlist != null){
            if(Wishlist::destroy($id)){
                return view('frontend.partials.wishlist');
            }
        }
    }
}

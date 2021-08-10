<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ReviewCollection;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index($id)
    {
        return new ReviewCollection(Review::where('product_id', $id)->latest()->get());
    }
}

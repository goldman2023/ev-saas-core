<?php

namespace App\Http\Controllers;

use CartService;
use Illuminate\Http\Request;

class EVCheckoutController extends Controller
{
    public function index(Request $request) {
        $cart_items = CartService::getItems();
        $total_items_count = CartService::getTotalItemsCount();

        $originalPrice = CartService::getOriginalPrice();
        $discountedAmount = CartService::getDiscountedAmount();
        $subtotalPrice = CartService::getSubtotalPrice();

        return view('frontend.checkout', compact('cart_items','total_items_count','originalPrice','discountedAmount','subtotalPrice'));
    }
}

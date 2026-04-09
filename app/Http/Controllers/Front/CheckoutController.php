<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(){

         // Get all items in the cart
        $items = Cart::getContent();

        
        // Calculate subtotal
        $subtotal = Cart::getSubTotal();

        // Total (assuming free shipping)
        $total = $subtotal;
        return view('front-end.cart.checkout',compact('items','subtotal','total'));
    }
}

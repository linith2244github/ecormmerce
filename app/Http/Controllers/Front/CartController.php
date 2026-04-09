<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index() {
       // Get all items in the cart
        $items = Cart::getContent();

        // Check if the cart is empty
        if($items->isEmpty()){
            return redirect()->route('home.index');
        }

        // Return the cart view with the items
        return view('front-end.cart.list', compact('items'));
    }
     public function add(string $id)
    {
        //get product where id
        $product = Product::where('id',$id)->with('Images')->first();
        $image = $product->Images->first();
        $cartItem = Cart::get($id); 
        if ($cartItem) {
            // If item exists, update the quantity (+1)
            Cart::update($id, [
                'quantity' => [
                    'relative' => true,
                    'value' => 1,
                ],
            ]);
        }else{
            // Add item to the cart
            Cart::add([
                'id' =>   $product->id, 
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'attributes' => [
                    'image' => $image->image,
                ],
            ]);
        }
        return redirect()->route('cart.list')->with('success', 'Item added to cart!');
    }

    public function update(Request $request){
        $id = $request->id;
        $action = $request->action;
        // Get the product and current cart item
        $product = Product::find($id);
        $cartItem = Cart::get($id);
        if (!$product || !$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found in cart!',
            ]);
        }
        // Calculate new quantity
        $newQuantity = $cartItem->quantity;

        if ($action === 'increase') {
            $newQuantity += 1;
        } elseif ($action === 'decrease') {
            if ($newQuantity > 1) {
                $newQuantity -= 1;
            }
        }
        // Check if new quantity exceeds stock
        if ($newQuantity > $product->qty) {
            return response()->json([
                'success' => false,
                'message' => 'Quantity exceeds available stock!',
            ]);
        }
        // Update quantity in cart
        Cart::update($id, [
            'quantity' => [
                'relative' => false,
                'value' => $newQuantity,
            ],
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Quantity updated successfully!',
            'newQuantity' => $newQuantity,
        ]);
    }



    // Remove an item from the cart
    public function remove(string $id)
    {
        // Remove the item from the cart
        Cart::remove($id);

        // Redirect back with success message
        return redirect()->route('cart.list')->with('success', 'Item removed from cart!');
    }

    // Clear the entire cart
    public function clear()
    {
        // Clear all items from the cart
        Cart::clear();
        // Redirect back with success message
        return redirect()->route('cart.list')->with('success', 'Cart cleared!');
    }
}

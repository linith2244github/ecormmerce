<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function homePage()
    {
        // Get latest 3 category
        $categories = Category::limit(3)->get();
        $products = Product::orderBy('id', 'desc')->where('status', 1)->with('Images')->limit(9)->get();

        $data['categories'] = $categories;
        $data['products'] = $products;

        return view('front-end.index', $data);
    }

    public function viewProduct(Request $request)
    {
        // Fetch product details
        $product = Product::where('id', $request->id)->with('Images')->first();

        // Check if product exists
        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product not found'
            ]);
        }

        return response()->json([
            'status' => 200,
            'product' => $product
        ]);
    }

    public function productCategory(string $id)
    {
        $products = Product::where('category_id', $id)->where('status', 1)->with('Images')->paginate(9);

        if (!$products) {
            return response()->json([
                'status' => 404,
                'message' => 'Products not found for this category'
            ]);
        }

        return view('front-end.shop', [
            'products' => $products
        ]);
    }
}

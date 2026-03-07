<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back-end.product');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function list()
    {
        $products = Product::orderBy('id', 'desc')->with('Images', 'Categories', 'Brands')->get();
        return response()->json([
            'status' => 200,
            'products' => $products
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'price' => 'required|numeric',
            'qty' => 'required|numeric'
        ]);
        if($validator->passes()){
            // Save Product to table in db
            $product = new Product();
            $product->name = $request->title;
            $product->desc = $request->desc;
            $product->price = $request->price;
            $product->qty = $request->qty;
            $product->category_id = $request->category;
            $product->brand_id = $request->brand;
            $product->color = implode(',', $request->color);
            // [4,3,2] => "4,3,2"
            $product->user_id = Auth::user()->id;
            $product->status = $request->status;
            $product->save();

            // Save to images table
            if($request->image_uploads){
                $images = $request->image_uploads;
                foreach($images as $img){
                    $image = new ProductImage();
                    $image->image = $img;
                    $image->product_id = $product->id;
                    // Move image to product directory
                    if(File::exists(public_path("uploads/temp/$img"))){
                        // copy image to product directory
                        File::copy(public_path("uploads/temp/$img"), public_path("uploads/product/$img"));
                        // delete from temporary directory
                        File::delete(public_path("uploads/temp/$img"));
                    }
                    $image->save();
                }
            }
            return response([
                'status' => 200,
                'message' => 'Product created successfully'
            ]);
        }else{
            return response([
                'status' => 500,
                'message' => 'Validation Failed',
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function data()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        $colors = Color::orderBy('id', 'desc')->get();
        return response([
            'status' => 200,
            'data' => [
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors
            ]
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $product = Product::find($request->id);
        $productImages = ProductImage::where('product_id', $request->id)->get();
        $categories = Category::orderBy('id', 'desc')->get();
        $brands = Brand::orderBy('id', 'desc')->get();
        $colors = Color::orderBy('id', 'desc')->get();

        return response([
            'status' => 200,
            'data' => [
                'product' => $product,
                'productImages' => $productImages,
                'categories' => $categories,
                'brands' => $brands,
                'colors' => $colors
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
    }
}

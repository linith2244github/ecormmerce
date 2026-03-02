<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        return view('back-end.category');
    }

    public function list(){
        $categories = Category::orderBy('id', 'desc')->get();

        if($categories->isNotEmpty()){
            return response()->json([
                'status' => 200,
                'categories' => $categories
            ]); // HTTP 200
        }
        return response()->json([
            'status' => 404,
            'message' => 'No categories found',
            'categories' => []
        ], 404); // HTTP 404
    }
    public function upload(Request $request){
        $validator = Validator::make($request->all(), [
            'image' => 'required'
        ]);
        if($validator->passes()){
            $file = $request->file('image');
            $imageName = rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
            $file->move('uploads/temp', $imageName);
            return response()->json([
                'status' => 200,
                'message' => 'Image upload successfull',
                'image' => $imageName
            ]);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Image upload failed',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function  cancelImage(Request $request){
        if($request->image){
            $tempDir = public_path("uploads/temp/$request->image");
            if(File::exists($tempDir)){
                File::delete($tempDir);
                return response()->json([
                    'status' => 200,
                    'message' => 'Image deleted successfully'
                ]);
            }
        }
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);
        if($validator->passes()){
            $category = new Category();
            $category->name = $request->name;
            $category->status = $request->status;
            // change image directory
            if($request->category_image){
                $tempDir = public_path("uploads/temp/$request->category_image");
                $catDir = public_path("uploads/category/$request->category_image");
                if(File::exists($tempDir)){
                    File::move($tempDir, $catDir);
                    // File::copy($tempDir, $catDir);
                    // File::delete($tempDir);
                }
                $category->image = $request->category_image;
            }
            

            // Move image from temp to category folder
            // if ($request->filled('category_image')) {
            //     $fileName = $request->category_image;
            //     $tempPath = public_path('uploads/temp/' . $fileName);
            //     $categoryPath = public_path('uploads/category/' . $fileName);
            //     // Ensure category folder exists
            //     if (!File::exists(public_path('uploads/category'))) {
            //         File::makeDirectory(public_path('uploads/category'), 0755, true);
            //     }
            //     // Move only if file exists
            //     if (File::exists($tempPath) && is_file($tempPath)) {
            //         File::move($tempPath, $categoryPath);
            //         $category->image = $fileName;
            //     } else {
            //         $category->image = null;
            //     }

            // } else {
            //     $category->image = null;
            // }
            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category created successfully',
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function edit(Request $request)
    {
        $category = Category::find($request->id);

        if($category != null){
            return response()->json([
                'status' => 200,
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Category not found with id ' . $request->id
            ]);
        }
    }

    public function update(Request $request)
    {
        $category = Category::find($request->category_id);

        if($category == null){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found with id ' . $request->category_id
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if($validator->passes()){
            $category->name = $request->name;
            $category->status = $request->status;
            // change image directory
            if($request->category_image){
                $tempDir = public_path("uploads/temp/$request->category_image");
                $catDir = public_path("uploads/category/$request->category_image");
                if(File::exists($tempDir)){
                    File::move($tempDir, $catDir);
                    // File::copy($tempDir, $catDir);
                    // File::delete($tempDir);
                }
                // remove old image from category folder
                $cateDir = public_path("uploads/category/$category->image");
                if(File::exists($cateDir)){
                    File::delete($cateDir);
                }
                $image = $request->category_image;

            }else if($request->old_image){
                $image = $request->old_image;
            }
            else{
                $image = null;
            }
            $category->image = $image;

            $category->save();

            return response()->json([
                'status' => 200,
                'message' => 'Category updated successfully',
                'category' => $category
            ]);
        } else {
            return response()->json([
                'status' => 500,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function destroy(Request $request)
    {
        $categories = Category::find($request->id);
        if($categories == null){
            return response()->json([
                'status' => 404,
                'message' => 'Category not found with id ' . $request->id  
            ]);  
        }
        if($categories->image != null){
            $catDir = public_path("uploads/category/$categories->image");
            if(File::exists($catDir)){
                File::delete($catDir);
            }
        }
        $categories->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Category deleted successfully'    
        ]);
    }
}

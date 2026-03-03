<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('back-end.brand', compact('categories'));
    }

    public function list(Request $request)
    {
        $limits = 5;
        $page = $request->page;
        $offset = ($page - 1) * $limits;

        if(!empty($request->search)){
            $brands = Brand::orderBy('id', 'desc')
                            ->where('name', 'like', '%' . $request->search . '%')
                            ->with('category')
                            ->limit($limits)
                            ->offset($offset)
                            ->get();
            $totalRecord = Brand::where('name', 'like', '%' . $request->search . '%')->count();
        }else{
            $brands = Brand::orderBy('id', 'desc')
                            ->with('category')
                            ->limit($limits)
                            ->offset($offset)
                            ->get();
            $totalRecord = Brand::count();
        }
        //total record
        $totalPage = ceil($totalRecord / $limits);
        
        return response()->json([
            'status' => 200,
            'page' => [
                'totalRecord' => $totalRecord,
                'totalPage' => $totalPage,
                'currentPage' => $page,
            ],
            'brands' => $brands
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:brands,name',
            'category' => 'required'
        ]);
        if($validator->passes()){
            $brand = new Brand();
            $brand->name = $request->name;
            $brand->category_id = $request->category;
            $brand->status = $request->status;
            $brand->save();
            return response()->json([
                'status' => 200,
                'message' => 'Brand created successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'message' => 'Failed to create brand',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required:unique:brands,name,' . $request->brand_id
        ]);
        if($validator->passes()){
            $brand = Brand::find($request->brand_id);
            if($brand == null){
                return response()->json([
                    'status' => 404,
                    'message' => 'Brand not found with id ' . $request->brand_id
                ]);
            }else{
                $brand->name = $request->name;
                $brand->category_id = $request->category;
                $brand->status = $request->status;
                $brand->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Brand updated successfully'
                ]);
            }
        }else{
            return response()->json([
                'status' => 422,
                'message' => 'Failed to create brand',
                'errors' => $validator->errors()
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $brand = Brand::find($request->id);
        if($brand == null){
            return response()->json([
                'status' => 404,
                'message' => 'Brand not found with id ' . $request->id
            ]);
        }else{
            $brand->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Brand deleted successfully'
            ]);
        }
    }
}

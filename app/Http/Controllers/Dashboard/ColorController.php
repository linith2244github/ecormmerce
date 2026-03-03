<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('back-end.color');
    }

    public function list(Request $request)
    {
        $limits = 5;
        $page = $request->page;
        $offset = ($page - 1) * $limits;

        if(!empty($request->search)){
            $colors = Color::orderBy('id', 'desc')
                            ->where('name', 'like', '%' . $request->search . '%')
                            ->limit($limits)
                            ->offset($offset)
                            ->get();
            $totalRecord = Color::where('name', 'like', '%' . $request->search . '%')->count();
        }else{
            $colors = Color::orderBy('id', 'desc')
                            ->limit($limits)
                            ->offset($offset)
                            ->get();
            $totalRecord = Color::count();
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
            'colors' => $colors
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:colors,name'
        ]);
        if($validator->passes()){
            $color = new Color();
            $color->name = $request->name;
            $color->color_code = $request->color;
            $color->status = $request->status;
            $color->save();
            return response()->json([
                'status' => 200,
                'message' => 'Color created successfully'
            ]);
        }else{
            return response()->json([
                'status' => 422,
                'message' => 'Failed to create brand',
                'errors' => $validator->errors()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $color = Color::find($request->id);
        if($color == null){
            return response()->json([
                'status' => 404,
                'message' => 'Coolor not found with id ' . $request->id
            ]);
        }else{
            $color->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Color deleted successfully'
            ]);
        }
    }
}

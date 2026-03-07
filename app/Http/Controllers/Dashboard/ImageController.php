<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageController extends Controller
{
    public function upload(Request $request) {
        if($request->hasFile('image')) {
            $files = $request->file('image');
            $images = [];
            foreach($files as $file) {
                $fileName = rand(0, 999999999) . '.' . $file->getClientOriginalExtension();
                $images[] = $fileName;
                $file->move(public_path('uploads/temp'), $fileName);
            }
            return response([
                'status' => 200,
                'message' => 'Image uploaded successfully',
                'images' => $images
            ]);
        }
    }

    public function cancel(Request $request) {
        $temp_path = public_path("uploads/temp/$request->image");
        if(File::exists($temp_path)) {
            File::delete($temp_path);
            return response([
                'status' => 200,
                'message' => 'Image deleted successfully'
            ]);
        }
    }
}

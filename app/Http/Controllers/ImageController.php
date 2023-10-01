<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function create(Request $request) {
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'product_'.time().'.'.$image->extension();
            $path = $image->storeAs('public/product', $filename);
            $image = Image::create([
                'filename' => $filename,
                'url' => $path
            ]);
            return response()->json(new ImageResource($image));
        }
    }

    public function delete($image_id) {
        $image = Image::find($image_id);
        if(empty($image)) {
            return response()->json([
                'message' => 'Image is not exist!'
            ], 404);
        }
        Storage::delete($image->url);
        $image->delete();
        return response()->json([
            'message' => 'Delete Successful'
        ]);
    }
}

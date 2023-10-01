<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;

class ImageController extends Controller
{
    public function create(Request $request) {
        $rules = [
            'image' => [
                'required',
                'image'
            ]
        ];
        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $image = $request->file('image');
            $filename = 'product_'.time().'.'.$image->extension();
            $path = $image->store('product', 'public');
            $image = Image::create([
                'filename' => $filename,
                'url' => $path
            ]);
            return response()->json(new ImageResource($image));
        }
        return response()->json(array(
            'errors' => $validator->getMessageBag()->toArray()

        ), 500);
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

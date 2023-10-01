<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $images = $input['images'];
        unset($input['images']);
        $user_id = 1;
        $input['user_id'] = $user_id;
        $product = Product::create($input);
        if(count($images) > 1) {
            Image::whereIn('id', $images)->update([
                'product_id' => $product->id
            ]);
        }
        return response()->json(new ProductResource($product));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $product_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        if(empty($product)) {
            return response()->json([
                'message' => 'Product is not exist!'
            ], 404);
        }
        $input = $request->all();
        $images = $input['images'];
        unset($input['images']);
        $product->update($input);
        if(count($images) > 1) {
            $product->removeAllImage();
            Image::whereIn('id', $images)->update([
                'product_id' => $product->id
            ]);
        }
        return response()->json(new ProductResource($product));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($product_id)
    {
        $product = Product::find($product_id);
        if(empty($product)) {
            return response()->json([
                'message' => 'Product is not exist!'
            ], 404);
        }
        $product->deleteAllImage();
        $product->delete();
        return response()->json([
            'message' => 'Delete Successful'
        ]);
    }
}

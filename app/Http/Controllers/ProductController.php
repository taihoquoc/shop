<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();
        $rules = [
            'title' => 'required,string',
            'brand_id' => 'required,integer',
            'price' => 'required,numeric',
            'promo_price' => 'numeric',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->passes()) { 
            $images = $input['images'];
            unset($input['images']);
            $user_id = $user->id;
            $input['user_id'] = $user_id;
            $product = Product::create($input);
            if(count($images) > 1) {
                Image::whereIn('id', $images)->update([
                    'product_id' => $product->id
                ]);
            }
            return response()->json(new ProductResource($product));
        }
        
        return response()->json(array(
            'errors' => $validator->getMessageBag()->toArray()

        ), 500);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($product_id)
    {
        $product = Product::find($product_id);
        if(empty($product)) {
            return redirect()->route('homepage')->with('error', 'Product is not exist!');
        }

        return response()->view('product_detail', ['product' => new ProductResource($product)]);
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
        $rules = [
            'title' => 'required,string',
            'brand_id' => 'required,integer',
            'price' => 'required,numeric',
            'promo_price' => 'numeric',
        ];
        $input = $request->all();
        $validator = Validator::make($input, $rules);

        if ($validator->passes()) {
            $user_id = Auth::user()->id;
            $input['user_id'] = $user_id; 
            $product->update($input);
            if(count($images) > 1) {
                $product->removeAllImage();
                Image::whereIn('id', $images)->update([
                    'product_id' => $product->id
                ]);
            }
            return response()->json(new ProductResource($product));
        }

        return response()->json(array(
            'errors' => $validator->getMessageBag()->toArray()

        ), 500);
        
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

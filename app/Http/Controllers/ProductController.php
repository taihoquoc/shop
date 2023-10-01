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
    /**
     * @OA\Post(
     *      path="product/create",
     *      operationId="createProduct",
     *      tags={"Product"},
     *      summary="Store new product",
     *      description="Returns product data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *            type="object",
     *              @OA\Property(property="title", type="string", example="Product Title"),
     *              @OA\Property(property="description", type="string", example="This is a sample product."),
     *              @OA\Property(property="price", type="number", format="float", example=19.99),
     *              @OA\Property(property="promo_price", type="number", format="float", example=10.99),
     *              @OA\Property(property="brand_id", type="number",  example=1),
     *              @OA\Property(property="images", type="array", @OA\Items(type="number", example=1)),
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     * )
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *      path="/product/{product_id}",
     *      operationId="updateProduct",
     *      tags={"Product"},
     *      summary="Update existing product",
     *      description="Returns updated product data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="product_id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *            type="object",
     *              @OA\Property(property="title", type="string", example="Product Title"),
     *              @OA\Property(property="description", type="string", example="This is a sample product."),
     *              @OA\Property(property="price", type="number", format="float", example=19.99),
     *              @OA\Property(property="promo_price", type="number", format="float", example=10.99),
     *              @OA\Property(property="brand_id", type="number",  example=1),
     *              @OA\Property(property="images", type="array", @OA\Items(type="number", example=1)),
     *          )
     *      ),
     *      @OA\Response(
     *          response=202,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Product")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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
    /**
     * @OA\Delete(
     *      path="/product/{product_id}",
     *      operationId="deleteProduct",
     *      tags={"Product"},
     *      summary="Delete existing product",
     *      description="Deletes a record and returns no content",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Product id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Delete Successful"),
     *          )
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
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

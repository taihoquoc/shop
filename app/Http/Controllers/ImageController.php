<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\File;
/**
 * @OA\Schema(
 *      schema="FileUpload",
 *      title="FileUpload",
 *      description="File upload details",
 *      @OA\Property(property="file", type="string", format="binary", description="Uploaded file"),
 *      @OA\Property(property="description", type="string", example="File description"),
 *      @OA\Property(property="key", type="string", example="image"),
 * )
 */
class ImageController extends Controller
{
    /**
     * @OA\Post(
     *      path="image/create",
     *      operationId="createImage",
     *      tags={"Image"},
     *      summary="Store new image",
     *      description="Returns image data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          description="File upload details",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(ref="#/components/schemas/FileUpload"),
     *              mediaType="image",
     *          )
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Image")
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

    /**
     * @OA\Delete(
     *      path="/delete/{image_id}",
     *      operationId="deleteImage",
     *      tags={"Image"},
     *      summary="Delete existing image",
     *      description="Deletes a record and returns no content",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="image_id",
     *          description="Image id",
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

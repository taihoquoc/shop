<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserController extends Controller
{
    /**
     * @OA\POST(
     *      path="/api/user/login",
     *      tags={"Users"},
     *      summary="User Login",
     *      description="Returns token",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *            type="object",
     *              @OA\Property(property="email", type="string", format="email", example="master@mail.com"),
     *              @OA\Property(property="password", type="string", example="password"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *            type="object",
     *            @OA\Property(property="access_token", type="string", example=""),
     *            @OA\Property(property="token_type", type="string", example="bearer"),
     *          )
     *      ),
     * )
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        if (! $token = $this->guard()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer'
        ]);
    }

    public function guard()
    {
        return Auth::guard('api');
    }
}

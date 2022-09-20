<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerEmailRequest;
use App\Http\Requests\CustomerPasswordRequest;
use App\Http\Requests\CustomerProfileRequest;
use App\Http\Requests\Manage\UserRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Http\Requests\UserProfileRequest;
use App\Http\Resources\CustomerResource;
use App\Http\Resources\UserFullResource;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Validator;


class AuthController extends Controller
{


    public function login(Request $request){
     	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([ 'errors' => $validator->errors()], 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['message' => 'Unauthorized'  ], 422);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        $inputs = $request->validate( [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|string|min:3',
            'password' => 'required|string|min:6',
        ]);


        $user = User::create(array_merge(
            $inputs,
            ['password' => bcrypt($request->password) , 'branche_id'=> 0 ]
        ));

        return response()->json([
            'message' => 'User successfully registered',
            'data' => $user
        ], 201);
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        if (auth()->check())
            return response()->json(auth()->user());
        else
            return  [];
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 240,
            'data' => auth()->user() ,
        ]);
    }

}


<?php

namespace App\Http\Controllers\Auth\Api;


use App\Models\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Controllers\Auth\Api\BaseController;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;



class AuthenticationController extends BaseController
{

    //use this method to signin users
    public function login(LoginRequest $request)
    {
        //$attempt = JWTAuth::attempt(['email' => $request->get('email'), 'password' => $request->get('password')]);
        $attempt = JWTAuth::attempt($request->validated());


        if ($attempt) {
            return $this->handleResponse($this->createNewToken($attempt), 'User logged-in!');
        } else {
            return $this->handleError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        //Request is validated, do logout
        $forever = true;
        try {

            $this->user = JWTAuth::parseToken()->invalidate($forever);

            return response()->json([
                'success' => true,
                'message' => 'User has been logged out'
            ]);
        }
        catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    protected function createNewToken($token){
        return [
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60,
            'user_name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ];
    }


    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }
}

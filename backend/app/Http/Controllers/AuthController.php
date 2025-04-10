<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
class AuthController extends Controller
{

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = Auth::guard('api')->user();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'role' => $user->role,
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60,
            'user' => new UserResource($user),
        ]);

    }

    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    public function logout()
    {
        Auth::guard('api')->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(Auth::guard('api')->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::guard('api')->factory()->getTTL() * 60
        ]);
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\AuthService;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginUserRequest;

class UserAuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request)
    {
        $validatedData = $request->validated();
        $token = $this->authService->register($validatedData, $request);

        return $this->respondWithToken($token);
    }
    public function login(LoginUserRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials, $request);
    
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Add a custom prefix to the token
        $prefixedToken = '2' . $token;
    
        return $this->respondWithToken($prefixedToken);
    }

    /**
     * Respond with a JWT.
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => JWTAuth::factory()->getTTL() * 60
        ]);
    }
}

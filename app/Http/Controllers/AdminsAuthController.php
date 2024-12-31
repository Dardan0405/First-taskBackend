<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\AdminAuthService;
use App\Http\Requests\RegisterRequestAdmin;
use App\Http\Requests\LoginAdmin;
class AdminsAuthController extends Controller
{
    protected $authService;

    public function __construct(AdminAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new Instuctor.
     */
    public function register(RegisterRequestAdmin $request)
    {
        $validatedData = $request->validated();
        $token = $this->authService->register($validatedData, $request);

        return $this->respondWithToken($token);
    }
    public function login(LoginAdmin $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials, $request);
    
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Add a custom prefix to the token
        $prefixedToken = '4' . $token;
    
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

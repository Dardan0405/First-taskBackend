<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\InstructorsAuthService;
use App\Http\Requests\RegisterRequestInstructor;
use App\Http\Requests\LoginInstructorRequest;

class InstructorsAuthController extends Controller
{
    protected $authService;

    public function __construct(InstructorsAuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Register a new user.
     */
    public function register(RegisterRequestInstructor $request)
    {
        $validatedData = $request->validated();
        $token = $this->authService->register($validatedData, $request);

        return $this->respondWithToken($token);
    }
    public function login(LoginInstructorRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $token = $this->authService->login($credentials, $request);
    
        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    
        // Add a custom prefix to the token
        $prefixedToken = '1' . $token;
    
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

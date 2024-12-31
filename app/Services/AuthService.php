<?php

namespace App\Services;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;
use App\Models\UserDetails;

class AuthService
{
    public function register($validatedData, Request $request)
    {
        // Create a new user
        $user = User::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'User', // Adjust if role is dynamic
        ]);

        // Create the associated user details record
        UserDetails::create([
            'user_id' => $user->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'zip' => $request->input('zip'),
            'country' => $request->input('country'),
            'second_address' => $request->input('second_address'),
        ]);

        // Generate JWT token for the newly created user
        $token = JWTAuth::fromUser($user);
       
        // Return the token
        return $token;
        
    }
    public function login($credentials, Request $request)
    {
        // Attempt to authenticate the user using their credentials
        if (!$token = JWTAuth::attempt($credentials)) {
            return null; // Return null if authentication fails
        }

        return $token; // Return the generated JWT token
    }
    
}

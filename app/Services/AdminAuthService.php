<?php

namespace App\Services;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\Admin;
use App\Models\AdminDetails;

class AdminAuthService
{
    public function register($validatedData, Request $request)
    {
        // Create a new user
        $admins = Admin::create([
            'username' => $validatedData['username'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => 'Admin', // Adjust if role is dynamic
        ]);

        // Create the associated user details record
        AdminDetails::create([
            'user_id' => $admins->id,
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
        $token = JWTAuth::fromUser($admins);

        // Return the token
        return $token;
    }
    public function login($credentials, Request $request)
{
    // Use the guard specifically for Admin if not default
    if (!$token = auth('admin')->attempt($credentials)) {
        return null; // Return null if authentication fails
    }

    return $token; // Return the generated JWT token
}
    
}
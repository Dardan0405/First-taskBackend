<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequestAdmin extends FormRequest
{
    public function rules()
    {
        return [
            'username' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            // 'role' => 'required|in:Admin', 
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'city' => 'nullable|string',
            'state' => 'nullable|string',
            'zip' => 'nullable|string',
            'country' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'The username field is required.',
            'username.unique' => 'This username is already taken.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'first_name.required' => 'The first name field is required.',
            'last_name.required' => 'The last name field is required.',
            'phone.unique' => 'This phone number is already associated with another account.',
        ];
    }
}
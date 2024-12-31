<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginInstructorRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }
}

<?php

namespace App\Http\Controllers;


use App\Services\UserServices;

class UserController extends Controller{

    protected $userService;

    public function __construct(UserServices $userService)
    {
        $this->userService = $userService;
    }
    public function showAll()
    {
        $data = $this->userService->getAllUsers();

        if(!$data){
            return response()->json(['message' => 'Users not found'], 404);
        }

        return response()->json($data);
    }

   

  
}
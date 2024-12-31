<?php

namespace App\Http\Controllers;


use App\Services\UseServicesDetail;

class UserControllerDetails extends Controller{

    protected $userService;

    public function __construct(UseServicesDetail $userService)
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
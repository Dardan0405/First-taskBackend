<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserDetails;


class UserServices
{
    // Get User and User Details by User ID
   

    public function getAllUsers(){
        
        $users = User::all();

        if (!$users) {
            return null;
        }

        $userDetails = UserDetails::all()->keyBy("user_id");

        return $users->map(function($user) use ($userDetails){
            
            return [
                'user' => $user,
                
            ];

        } );
    }

  
    
}

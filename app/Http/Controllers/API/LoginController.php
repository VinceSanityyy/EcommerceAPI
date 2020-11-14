<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use App\Http\Controllers\API\BaseController as BaseController;

class LoginController extends BaseController
{
    public function Login(Request $request){

        if(Auth::attempt(['email' => $request->email, 'isVerified' => 1, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->accessToken; 
            $success['name'] =  $user->name;
            $success['user_id'] = $user->id;
            $success['role_id'] = $user->role_id;
            $success['email'] = $user->email;
            $success['image_link'] = $user->image_link;
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 

    }

    public function getUserInfo(Request $request){
        $user = Auth::user();
        return $user;
    }

    public function logout (Request $request) {
        $user = Auth::user();
        $token = $request->user()->token();
        // dd($user);
        $token->revoke();
        return $this->sendResponse('You have been successfully logged out!',200);
    }
}

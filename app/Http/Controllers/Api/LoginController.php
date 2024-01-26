<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
   
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);  
        }else{
            $login = (Auth::attempt([
                'email' => $request->email, 
                'password' => Hash::make($request->password)
            ])); 
            
            if (Auth::attempt([
                'email' => $request->email,
                'password' => $request->password
            ])) {
                return response()->json([
                    'status' => 200,
                    'message' => "Login Successfully",
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => "Invalid Email or Password",
                ], 500);
            }
            
        }
    }
} 

    
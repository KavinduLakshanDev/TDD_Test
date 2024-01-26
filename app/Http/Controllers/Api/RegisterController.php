<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class RegisterController extends Controller
{
    public function index()
    {
        $registers = User::all();

        if($registers->count() > 0){

            return response()->json([
                'status' => 200,
                'registers'=> $registers
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message'=> 'No any registered record found'
            ], 404);
        }  
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);
        }else{
            $register = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if($register){
                return response()->json([
                    'status' => 200,
                    'message' => "Register Added Successfully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!",
                ],500);
            }
        }
    }

   
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\PostNotification;
use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class SubscriberController extends Controller
{
    public function index()
    {
        $subscribers = Subscriber::all();
        if($subscribers->count() > 0){

            return response()->json([
                'status' => 200,
                'subscribers' => $subscribers
            ], 200);
        }else{
            return response()->json([
                'status' => 404,
                'message'=> 'No record found'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' =>'required|string|max:255',
            'website_id' => 'required|int|max:255|unique:subscribers,website_id,NULL,id,email,'.$request->email,
        ], [
            'website_id.unique' => 'You are already subscribed to this website.',
        ]);

        if($validator->fails()) {
            return response()->json([
                'status' => 422,
                'error' => $validator->messages()
            ], 422);
        }else{
            $subscriber = Subscriber::create([
                'email' => $request->email,
                'website_id' => $request->website_id,
                
            ]);
            
            if($subscriber){
                
                return response()->json([
                    'status' => 200,
                    'message' => "Subscriber Added Successfully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Something Went Wrong!",
                ],500);
            }
        }
    }

    public function show($id)
    {
        $subscriber = Subscriber::find($id);
        if($subscriber){
            return response()->json([
                'status' => 200,
                'subscriber' => $subscriber,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Subscriber found!",
            ],404);
        }
    }

    public function edit($id)
    {
        $subscriber = Subscriber::find($id);
        if($subscriber){
            return response()->json([
                'status' => 200,
                'subscriber' => $subscriber,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Subscriber found!",
            ],404);
        }
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255',
            'website_id' => 'required|int|max:255',
        ]);
        if($validator->fails()){

            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);

        }else{
            $subscriber = Subscriber::find($id);
            if($subscriber){
                $subscriber->update([
                    'email' => $request->email,
                    'website_id' => $request->website_id,
                ]);

            
                return response()->json([
                    'status' => 200,
                    'message' => "Subscriber Updates Successfully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Not found this Subscriber!",
                ],500);
            }
        }  
    }

    public function destroy($id)
    {
        $subscriber = Subscriber::find($id);
        if($subscriber){
            $subscriber->delete();
            return response()->json([
                'status' => 200,
                'message' => "Subscriber deleted Successfully!"
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Subscriber found!"
            ],404);
        } 
    }
}

<?php

namespace App\Http\Controllers\Api;

use id;
use App\Models\Post;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Mail\PostNotification;
use App\Http\Controllers\Controller;
use App\Mail\SubscriberNotifications;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        if($posts->count() > 0){

            return response()->json([
                'status' => 200,
                'posts'=> $posts
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
            'website_id' => 'required|int|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);
        }else{
            $post = Post::create([
                'website_id' => $request->website_id,
                'title' => $request->title,
                'description' => $request->description,
                
            ]);

            if($post){
                
                // Notify subscribers about the new post
                $subscribers = Subscriber::all();
                foreach ($subscribers as $subscriber) {
                    Mail::to($subscriber->email)->send(new SubscriberNotifications($subscribers, $post));
                }
                return response()->json([
                    'status' => 200,
                    'message' => "Post Create Successfully",
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
        $post = Post::find($id);
        if($post){
            return response()->json([
                'status' => 200,
                'post' => $post,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Post found!",
            ],404);
        }

    }

    public function edit($id)
    {
        $post = Post::find($id);
        if($post){
            return response()->json([
                'status' => 200,
                'post' => $post,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such post found!",
            ],404);
        }
    }

    public function update(Request $request,int $id)
    {
        $validator = Validator::make($request->all(), [
            'website_id' => 'required|int|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ]);
        if($validator->fails()){

            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);

        }else{
            $post = Post::find($id);
            if($post){
                $post->update([
                    'website_id' => $request->website_id,
                    'title' => $request->title,
                    'description' => $request->description,
                ]);

            
                return response()->json([
                    'status' => 200,
                    'message' => "Post Updates Successfully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Not found this Post!",
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $post = Post::find($id);
        if($post){
            $post->delete();
            return response()->json([
                'status' => 200,
                'message' => "Post deleted Successfully!"
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Post found!"
            ],404);
        }
    }
}
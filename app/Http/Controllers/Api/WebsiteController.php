<?php

namespace App\Http\Controllers\Api;

use App\Models\Website;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    //
    public function index()
    {
        $websites = Website::all();
        
        if($websites->count() > 0){

            return response()->json([
                'status' => 200,
                'websites'=> $websites
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
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);
        }else{
            $website = Website::create([
                'name' => $request->name,
                'url' => $request->url,
            ]);

            if($website){
                return response()->json([
                    'status' => 200,
                    'message' => "Website Added Successfully",
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
        $website = Website::find($id);
        if($website){
            return response()->json([
                'status' => 200,
                'website' => $website,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such website found!",
            ],404);
        }
    }

    public function edit($id)
    {
        $website = Website::find($id);
        if($website){
            return response()->json([
                'status' => 200,
                'website' => $website,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such website found!",
            ],404);
        } 
    }

    public function update(Request $request, int $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
        ]);
        
        if($validator->fails()){

            return response()->json([
                'status' => 422,  /*error message code*/
                'errors' => $validator->messages()
            ], 422);

        }else{
            $website = Website::find($id);
            if($website){
                $website->update([
                    'name' => $request->name,
                    'url' => $request->url,
                ]);

            
                return response()->json([
                    'status' => 200,
                    'message' => "Website Updates Successfully",
                ],200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => "Not found this website!",
                ],500);
            }
        }
    }

    public function destroy($id)
    {
        $website = Website::find($id);
        if($website){
            $website->delete();
            return response()->json([
                'status' => 200,
                'message' => "Website deleted Successfully!"
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => "No Such Website found!"
            ],404);
        }
    }
}

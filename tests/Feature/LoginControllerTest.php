<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Controllers\Api\LoginController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function it_loggin_user_credentials()
    {
        $LoginController = new LoginController();
        //request data
        $requestData = [
            'email' => 'kavindu@gmail.com',
            'password' => '123456',
        ];

        $validator = Validator::make($requestData, [
            'email' => 'required|email|max:255',
            'password' => 'required|string|max:255',
        ]);
        $isValid = !$validator->fails();

        Auth::shouldReceive('attept')
            ->with(['email' => $requestData['email'],
                     'password' =>Hash::make($requestData['password'])])
            ->once()
            ->andReturn(true);         

        //successful response
        $response = response()->json([
            'status' => 200,
            'message' => 'Login Successfully',
        ], 200);   
        
        //loginController return response
        $this->assertEquals($response->getContent(), $LoginController->login(new Request($requestData))->getContent());
    }
}

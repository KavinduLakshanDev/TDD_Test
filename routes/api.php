<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\WebsiteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('register', [RegisterController::class, 'index']);
Route::post('register', [RegisterController::class, 'store']);

Route::get('login', [LoginController::class, 'index']);
// Route::get('login/{id}', [LoginController::class, 'login']);
// Route::post('register', [RegisterController::class, 'store']);
Route::post('login', [LoginController::class, 'login']);

// website view, create, update, edit, delete
Route::get('websites', [WebsiteController::class, 'index']);
Route::post('websites', [WebsiteController::class, 'store']);
Route::get('websites/{id}', [WebsiteController::class, 'show']);
Route::get('websites/{id}/edit', [WebsiteController::class, 'edit']);
Route::put('websites/{id}/edit', [WebsiteController::class, 'update']);
Route::delete('websites/{id}/delete', [WebsiteController::class, 'destroy']);


// subscriber view, create, update, edit, delete
Route::get('subscribers', [SubscriberController::class, 'index']);
Route::post('subscribers', [SubscriberController::class, 'store']);
Route::get('subscribers/{id}', [SubscriberController::class, 'show']);
Route::get('subscribers/{id}/edit', [SubscriberController::class, 'edit']);
Route::put('subscribers/{id}/edit', [SubscriberController::class, 'update']);
Route::delete('subscribers/{id}/delete', [SubscriberController::class, 'destroy']);


// posts view, create, update, edit, delete
Route::get('posts', [PostController::class, 'index']);
Route::post('posts', [PostController::class, 'store']);
Route::get('posts/{id}', [PostController::class, 'show']);
Route::get('posts/{id}/edit', [PostController::class, 'edit']);
Route::put('posts/{id}/edit', [PostController::class, 'update']);
Route::delete('posts/{id}/delete', [PostController::class, 'destroy']);



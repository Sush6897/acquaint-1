<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('post',[PostController::class,'post'])->middleware('auth:sanctum');
Route::get('posts/{post}', [PostController::class, 'show'])->middleware('auth:sanctum');
Route::post('posts/{post}/comments', [PostController::class, 'addComment'])->middleware('auth:sanctum');
Route::post('posts/{post}/tags', [PostController::class, 'addTag'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);

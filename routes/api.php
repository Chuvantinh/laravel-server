<?php

use App\Http\Controllers\api\v1\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function() {
    Route::post('register', 'register');
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::get('/user', function (Request $request) {
    $user = $request->user();

    return response()->json([
        'id' => $user->id,
        'name' => $user->name,
     ]);

})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->group(function(){
    Route::resource('post', PostController::class);
});
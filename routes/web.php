<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\v1\AuthController;

Route::get('/', function () {
    return view('welcome');
});
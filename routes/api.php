<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::get('test', function () {
    return response()->json([
        'status' => "success",
        'message' => 'API test route is working'
    ], 200);
});


Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login'])->name('login');
Route::post('register', [\App\Http\Controllers\Api\Auth\RegisterController::class, 'register'])->name('register');

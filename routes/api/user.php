<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/



Route::get('test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'user test route is working'
    ], 200);
});

// A U T H E N T I C A T E D     R O U T E S
Route::middleware(['auth:user-api', 'scopes:user'])->name('user.')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Api\User\LogoutController::class, 'logout']);
    Route::apiResource('post', \App\Http\Controllers\Api\User\PostController::class);

    Route::get('post/{post}/comments', [\App\Http\Controllers\Api\User\CommentController::class, 'index']);
    Route::post('post/{post}/comments', [\App\Http\Controllers\Api\User\CommentController::class, 'store']);
    Route::get('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\User\CommentController::class, 'show']);
    Route::put('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\User\CommentController::class, 'update']);
    Route::delete('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\User\CommentController::class, 'destroy']);
});

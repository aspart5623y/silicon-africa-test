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
        'message' => 'admin test route is working'
    ], 200);
});

// A U T H E N T I C A T E D     R O U T E S
Route::middleware(['auth:admin-api', 'scopes:admin'])->name('admin.')->group(function () {
    Route::post('logout', [\App\Http\Controllers\Api\Admin\LogoutController::class, 'logout']);

    Route::apiResource('post', \App\Http\Controllers\Api\Admin\PostController::class)->except('store');

    Route::get('user', [\App\Http\Controllers\Api\Admin\UserController::class, 'index']);
    Route::get('user/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'show']);
    Route::put('user/{user}/can-post', [\App\Http\Controllers\Api\Admin\UserController::class, 'canPost']);
    Route::delete('user/{user}', [\App\Http\Controllers\Api\Admin\UserController::class, 'destroy']);

    Route::get('post/{post}/comments', [\App\Http\Controllers\Api\Admin\CommentController::class, 'index']);
    Route::get('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\Admin\CommentController::class, 'show']);
    Route::put('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\Admin\CommentController::class, 'update']);
    Route::delete('post/{post}/comments/{comment}', [\App\Http\Controllers\Api\Admin\CommentController::class, 'destroy']);

});

<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ImageController;

Route::post('image', [ImageController::class, ('store')]);

Route::controller(PostController::class)->group(function(){
    Route::get('posts', 'show');
    Route::get('post/{id}', 'detail');
    Route::post('post', 'store');
    Route::delete('post/{id}', 'delete');
    Route::put('post/edit/{id}', 'update');
});

Route::controller(CategoryController::class)->group(function(){
    Route::get('category', 'show');
    Route::post('category', 'store');
    Route::delete('category/{id}', 'delete');
    Route::put('category/{id}', 'update');
});

Route::controller(VerifyEmailController::class)->group(function(){
    Route::get('email/verify/{id}/{hash}', 'verify')
    ->name('verification.verify');
    Route::get('verify-email/{id}', 'send')
    ->name('verification.send');
});

Route::controller(PasswordController::class)->group(function(){
    Route::post('forgot-password', 'sendReset')
    ->name('password.email');
    Route::post('reset-password', 'resetPassword');
});

Route::get('reset-password/{token}/{email}', function($token,$email){
    return redirect(url(env('FRONT_END_APP').'reset-pwd/'.$token.'/'.$email));
})->name('password.reset');

Route::controller(AuthController::class)->group(function(){
    Route::post('login', 'login');
    Route::post('register', 'register');
});
Route::middleware(['auth:sanctum'])->group(function () {
    Route::controller(AuthController::class)->group(function(){
        Route::post('logout', 'logout');
    });
    Route::get('user', function(Request $request){
        return response()->json([
            'message' => 'harus auth'
        ]);
    });
});

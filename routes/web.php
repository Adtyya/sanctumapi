<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\Tes;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});
Route::get('reset-pwd/{str}/{email}', function($str, $email) {
    return response()->json([
        'message' => 'success',
        'token' => $str,
        'email' => $email
    ]);
});

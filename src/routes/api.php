<?php

use App\Http\Controllers\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\User\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

Route::post('user/signup', [AuthController::class, 'signUp']);
Route::post('user/login', [AuthController::class, 'login']);

Route::post('admin/signup', [AdminAuthController::class, 'signUp']);
Route::post('admin/login', [AdminAuthController::class, 'login']);
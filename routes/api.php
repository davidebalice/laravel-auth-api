<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgetController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

// Login Routes 
Route::post('/login',[AuthController::class, 'Login']);

// Register Routes 
Route::post('/register',[AuthController::class, 'Register']);

// Forget Password Routes 
Route::post('/forgetpassword',[ForgetController::class, 'ForgetPassword']);

 // Reset Password Routes 
Route::post('/resetpassword',[ResetController::class, 'ResetPassword']);

 // Current User Route 
Route::get('/user',[UserController::class, 'User'])->middleware('auth:api');

Route::controller(ProductController::class)->group(function(){
    Route::get('/products', 'Index')->name('index')->middleware('auth:api');
    Route::post('/products/store', 'Store')->name('products.store')->middleware('auth:api');
    Route::get('/products/edit/{id}', 'Edit')->name('products.edit')->middleware('auth:api');   
    Route::post('/products/update/{id}', 'Update')->name('products.update')->middleware('auth:api'); 
    Route::get('/products/delete/{id}', 'Delete')->name('products.delete')->middleware('auth:api'); 
});
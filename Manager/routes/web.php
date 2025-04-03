<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get("/admin/login" , function ()  {

// })->name('login');
// 
Route::get('signup',[AuthController::class, 'register'])->name('inscrire');
Route::post('signup',[AuthController::class, 'create'])->name('register');
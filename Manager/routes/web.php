<?php

use App\Http\Controllers\AuthController;
use App\Livewire\RegisterUser;
use App\Livewire\SigninUser;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::get("/admin/login" , function ()  {

// })->name('login');
// 
// Route::post('signup',[AuthController::class, 'create'])->name('register');
// Route::post('/login', [AuthController::class, 'store'])->name('login');
// Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
Route::get('signup', RegisterUser::class)->name('inscrire');
Route::get('login' , SigninUser::class)->name('login');
Route::post('logout' , [SigninUser::class , 'logout'])->name('deconnecter');
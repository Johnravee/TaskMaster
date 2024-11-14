<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



Route::post('/users', [UserController::class, 'store']); // Create new user
Route::post('/tasks', [ScheduleController::class, 'store']); // Create new task
Route::get('/schedules', [ScheduleController::class, 'show']); // Show user schedules
Route::delete('/schedule', [ScheduleController::class, 'destroy']); // Delete schedule
Route::post('/form', [AuthController::class, 'formLogin']); // Login via form


Route::patch('/schedule', [ScheduleController::class, 'update']);  // Update schedule (testing nalang)



Route::get('/auth/google/redirect', function () {  // Login via google
    return Socialite::driver('google')->redirect();  
});



//Github Auth
Route::get('/auth/github/redirect', function () {  // Login via github
    return Socialite::driver('github')->redirect();
});



Route::get('/auth/google/callback', [AuthController::class, 'googleLogin']); // callbacks
Route::get('/auth/github/callback', [AuthController::class, 'githubLogin']); // callbacks



  // Logout route
    Route::get('/logout', function (Request $request) {  // Logout authenticated user
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
       
    })->name('logout');
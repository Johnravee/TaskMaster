<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



Route::post('/create-user', [UserController::class, 'store']);
Route::post('/create-task', [ScheduleController::class, 'store']);
Route::get('/fetch-schedules', [ScheduleController::class, 'show']);
Route::delete('/destroy-schedule', [ScheduleController::class, 'destroy']);


Route::post('/auth/taskmaster/form', [UserController::class, 'formLogin']);

//Google Auth
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});



 
Route::get('/auth/google/callback', [UserController::class, 'googleLogin']);


//Github Auth
Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/github/callback', [UserController::class, 'githubLogin']);



  // Logout route
    Route::get('/logout', function (Request $request) {
        Auth::logout(); 
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); 
        return redirect()->route('login'); // Redirect to login
    })->name('logout');
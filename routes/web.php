<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;


//Aayusin pa yung routing 
Route::get('/', function () {
    return inertia('RegistrationForm');
});

Route::get('/form', function(){
    return inertia('EventForm');
});


//for testing only (post talaga 'to)
Route::get('/create-user', [UserController::class, 'store']);


//for testing only (post talaga 'to)
Route::get('/create-task', [ScheduleController::class, 'store']);


// testing fetch all schedules (gawing post pag oks na yung front-end)
Route::get('/schedules', [ScheduleController::class, 'show']);



//Google Auth
 
Route::get('/auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();

    Log::info('Google 2.0 Auth id ng animal: ' . $user->id);
 
});
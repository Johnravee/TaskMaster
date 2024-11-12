<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;



//for testing only (post talaga 'to)
Route::get('/create-user', [UserController::class, 'store']);


//for testing only (post talaga 'to)
Route::get('/create-task', [ScheduleController::class, 'store']);


// testing fetch all schedules (gawing post pag oks na yung front-end)
Route::get('/schedules', [ScheduleController::class, 'show']);


// testing delete schedules (gawing delete pag oks na yung front-end)
Route::get('/destroy-schedule', [ScheduleController::class, 'destroy']);


Route::get('/auth/taskmaster/form');





//Google Auth
Route::get('/auth/google/redirect', function () {
    return Socialite::driver('google')->redirect();
});
 
Route::get('/auth/google/callback', function () {
    $user = Socialite::driver('google')->user();

    Log::info('Google 2.0 Auth id ng animal: ' . $user->id);
});


//Github Auth
Route::get('/auth/github/redirect', function () {
    return Socialite::driver('github')->redirect();
});
 
Route::get('/auth/github/callback', function () {
    $user = Socialite::driver('github')->user();
 
    Log::info('Github 2.0 Auth id ng animal: ' . $user->id);
});
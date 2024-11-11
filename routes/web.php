<?php

use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
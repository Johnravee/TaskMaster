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

Route::post('/create', [UserController::class, 'create'])->name('createUser');

Route::post('/create-task', [ScheduleController::class, 'create']);

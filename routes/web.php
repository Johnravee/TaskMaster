<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return inertia('RegistrationForm');
});

Route::post('/create', [UserController::class, 'create'])->name('createUser');
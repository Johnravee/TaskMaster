<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;



// kulang pa 'to ng schedule updation

// Ito lang yung magagamit na routes if user is authenticated  (matik babalik sa login route pag in-access yung mga route dito ng unauthenticated user)
Route::middleware('auth')->group(function (){

        Route::get("/dashboard", function (){
            return inertia('Dashboard');
        });

        Route::post('/tasks', [ScheduleController::class, 'store']); // Create new task

        Route::patch('/schedule', [ScheduleController::class, 'update']);  // Update schedule (linis nalang)
        
        Route::get('/schedules/{id}', [ScheduleController::class, 'show']); // Show user schedules
        
        Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']); // Delete schedule
        
        
        Route::get('/logout', function (Request $request) {  // Logout authenticated user
            Auth::logout(); 
            $request->session()->invalidate(); 
            $request->session()->regenerateToken(); 
            
        });
        
        
    });
    

// Ito lang yung magagamit na routes if user is not authenticated 
Route::middleware('guest')->group(function (){

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');

    Route::post('/form/login', [AuthController::class, 'formLogin']); // Login via form

    Route::post('/users', [UserController::class, 'store']); // Create new user

    Route::get('/auth/google/redirect', function () {  // Login via google
        return Socialite::driver('google')->redirect();  
    });

    Route::get('/auth/github/redirect', function () {  // Login via github
        return Socialite::driver('github')->redirect();
    });

    Route::get('/auth/google/callback', [AuthController::class, 'googleLogin']); // callbacks

    Route::get('/auth/github/callback', [AuthController::class, 'githubLogin']); // callbacks
});















   
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


Route::middleware(['auth', 'userGuard'])->group(function () {


    Route::get("/dashboard", function () {
            return inertia('Dashboard')->with("user_data", Auth::user());  
        })->name('dashboard');


    // Show a specific user's schedule by ID
    Route::get('/api/user/schedules', [ScheduleController::class, 'show']); 

    Route::get('/schedule/history', [ScheduleController::class, 'showHistory']); // Show user schedule history

    Route::get('/schedule/done', [ScheduleController::class,'showDone']);

    // Delete a specific schedule by ID
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']); 

    Route::delete('/clear/history', [ScheduleController::class, 'clearHistory']); // Clear user schedule history

    // Create a new task for the user's schedule
    Route::post('/api/schedule', [ScheduleController::class, 'store']); 

    // Update a user's schedule 
    Route::put('/user/schedule/update', [ScheduleController::class, 'update']);  

    Route::patch('/user/schedule/update', [ScheduleController::class, 'updateTaskToDone']);  // Update task status 
});

  // Logout the authenticated user
    Route::get('/logout', function (Request $request) {
        Auth::logout();  
        $request->session()->invalidate();  
        $request->session()->regenerateToken();  
        return redirect()->route('login');
    });



Route::middleware('guest')->group(function () {

    // show registration form
    Route::get('/form/register', [UserController::class, 'showRegistrationForm']);


    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  // Show login form

    // Handle login via form submission
    Route::post('/form/login', [AuthController::class, 'formLogin']); 

    // Register a new user (user registration)
    Route::post('/api/users', [UserController::class, 'store']); 
    
    Route::get('/api/auth/github/redirect', function () {
        return Socialite::driver('github')->redirect();  // Initiates the GitHub OAuth login process
    });


     Route::get('/api/auth/google/redirect', function () {
        return Socialite::driver('google')->redirect();  // Initiates the GitHub OAuth login process
    });

    // Callback route for Google OAuth login
    Route::get('/auth/google/callback', [AuthController::class, 'googleLogin']); // Google login callback handler

    // Callback route for GitHub OAuth login
    Route::get('/auth/github/callback', [AuthController::class, 'githubLogin']); // GitHub login callback handler

    Route::get('/', function () {
       return inertia('About');
    });


    // show reset email confirmation
    Route::get('/forgot', function(){
        return inertia('Forgot');
    });

    // handle data passed from forgot
    Route::post('/forgot/password', [UserController::class, 'resetPassword']);


    // reset password
    Route::get('/password/reset/{token}', function (string $token) {
   
        return inertia('Reset', ['token' => $token]);
});

    // handle password update
    Route::post('/reset-password', [UserController::class, 'updatePassword']);

    
});


Route::prefix('admin')->middleware(['auth', 'adminGuard'])->group(function () {
    Route::get('/', function () {
        return inertia('Admin');
    })->name('admin');

    Route::get('/counts', [ScheduleController::class, 'counter']);
});










Route::get('/test', function () {
    return inertia('Test');
});
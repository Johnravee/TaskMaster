<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

// Routes accessible only by authenticated users. If a user is unauthenticated, they will be redirected to the login route.
Route::middleware('auth')->group(function () {

    // Dashboard route, accessible only to authenticated users
        Route::get("/dashboard", function () {
            return inertia('Dashboard')->with("user_data", Auth::user());  // Renders the dashboard view
        })->name('dashboard');


    // Show a specific user's schedule by ID
    Route::get('/api/user/schedules', [ScheduleController::class, 'show']); // Show user schedules by ID

    Route::get('/schedule/history', [ScheduleController::class, 'showHistory']); // Show user schedule history

    // Delete a specific schedule by ID
    Route::delete('/schedule/{id}', [ScheduleController::class, 'destroy']); // Delete the specified schedule

    Route::delete('/clear/history', [ScheduleController::class, 'clearHistory']); // Clear user schedule history

    // Create a new task for the user's schedule
    Route::post('/api/schedule', [ScheduleController::class, 'store']); // Create a new task for the schedule

    // Update a user's schedule 
    Route::put('/user/schedule/update', [ScheduleController::class, 'update']);  // Update schedule 


    // Logout the authenticated user, invalidate the session, and regenerate the CSRF token for security
    Route::get('/logout', function (Request $request) {
        Auth::logout();  // Logs out the authenticated user
        $request->session()->invalidate();  // Invalidates the current session
        $request->session()->regenerateToken();  // Regenerates the CSRF token for security
        return response()->json([], 200);
    });

});




// Routes accessible only by unauthenticated (guest) users. Redirects them to authenticated routes if already logged in.
Route::middleware('guest')->group(function () {

    // show registration form
    Route::get('/form/register', [UserController::class, 'showRegistrationForm']);

    // Show the login form for users who are not authenticated
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  // Show login form

    // Handle login via form submission
    Route::post('/form/login', [AuthController::class, 'formLogin']); // Login via form submission

    // Register a new user (user registration)
    Route::post('/api/users', [UserController::class, 'store']); // Create a new user in the system

    // Redirect to Google for OAuth login
    Route::get('/api/auth/google/redirect', function () {
        return Socialite::driver('google')->redirect();  // Initiates the Google OAuth login process
    });

    // Redirect to GitHub for OAuth login
    Route::get('/api/auth/github/redirect', function () {
        return Socialite::driver('github')->redirect();  // Initiates the GitHub OAuth login process
    });

    // Callback route for Google OAuth login
    Route::get('/auth/google/callback', [AuthController::class, 'googleLogin']); // Google login callback handler

    // Callback route for GitHub OAuth login
    Route::get('/auth/github/callback', [AuthController::class, 'githubLogin']); // GitHub login callback handler
});


Route::prefix('admin')->middleware(['auth', 'adminGuard'])->group(function () {
    // routes for admin 

    Route::get('/users', [UserController::class, 'index']);
    Route::get('/schedules', [ScheduleController::class, 'index']);

});




Route::get('/test', function () {
    return inertia('Test');
});
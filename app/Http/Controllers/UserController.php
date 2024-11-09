<?php

namespace App\Http\Controllers;

use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{
    public function create(Request $request)
    {
        // Log the incoming request data (view in laravel.log)
        Log::info('Request data from registration form:', $request->all());

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

          // Log the validated data (view in laravel.log)
        Log::info('Validated data:', $validated);
        


        try {
            // Create new user
            $user = User::create($validated);

           // Log the created user (view in laravel.log)
            Log::info('User created:', $user->toArray());

            return response()->json([
                'user' => $user,
                'message' => 'User created successfully!',
            ], 201);  

        } catch (\Exception $e) {
        
            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'details' => $e->getMessage(),
            ], 500);  
        }
    }
}
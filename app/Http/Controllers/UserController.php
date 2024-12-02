<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;  
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Log; 

class UserController extends Controller
{

    public function showRegistrationForm(){
        return inertia('Registration');
    }




    public function store(UserStoreRequest  $request)
    {
        // Validate input
        $validated = $request->validated();
        $validated['isAdmin'] = false; 
        $validated['provider'] = 'form';

        try {

            // Create a new user 
            $user = User::create($validated);

            Log::info('User created successfully');
            return response()->json([
                'user' => $user,
                'message' => 'User created successfully!',
            ], 201);  

        } catch (\Exception $e) {
            Log::error("Error store". $e);
            return response()->json([
                'error' => 'Something went wrong. Please try again.',
                'details' => $e->getMessage(),
            ], 500);  
        }
    }




}
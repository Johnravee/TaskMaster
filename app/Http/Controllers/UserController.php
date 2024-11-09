<?php

namespace App\Http\Controllers;

use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  


class UserController extends Controller
{
    public function create(Request $request)
    {
    
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);


        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']), 
            ]);

          
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
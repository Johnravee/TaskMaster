<?php

namespace App\Http\Controllers;

use App\Models\User;  
use Illuminate\Http\Request;



class UserController extends Controller
{
    public function store(Request $request)
    {
        // Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::create($validated);


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

    
    public function update(Request $request){
        //pending
    }


    public function destroy(Request $request){
        //pending
    }
}
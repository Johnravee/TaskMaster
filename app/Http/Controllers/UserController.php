<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Models\User;  
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function store(UserStoreRequest  $request)
    {
        // Validate input
        $validated = $request->validated();

        try {
            $user = User::create($validated);


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



    public function formLogin(Request $request){
        try {
            //Validate
        $credentials = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);


            $user = User::where('email', $credentials['email'])
                ->where('provider', 'form') 
                ->first();


                if (!$user || !Hash::check($credentials['password'], $user->password)) {
                    return back()->withErrors([
                        'email' => 'The provided credentials do not match our records.',
                    ]);
                    
                }

            Auth::login($user,  true);


            /*  Redirect to page with auth data
                example :  return redirect()->intended('dashboard')->with('user_data', Auth::user()); */

                return response()->json([
                    'user' => $user,
                    'message' => 'User logged in via Form successfully!',
                ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Form authentication failed.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


     public function googleLogin(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                    'provider' => 'google',
                ],
                [
                    'name' => $googleUser ->getName(),
                ]
            );      

            //Authenticate  
            Auth::login($user, true);


            /*  Redirect to page with auth data
              example :  return redirect()->intended('dashboard')->with('user_data', Auth::user()); */
   
    
            return response()->json([
                'user' => $user,
                'message' => 'User logged in via Google successfully!',
            ], 200);

        } catch (\Exception $e) {
            
            return response()->json([
                'error' => 'Google authentication failed.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }


   public function githubLogin(Request $request)
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            $user = User::updateOrCreate(
                [
                    'email' => $githubUser->getEmail(),
                    'provider' => 'github',
                ],
                [
                    'name' => $githubUser ->getName(),
                ]
            );


            //Authenticate
            Auth::login($user, true);


            /*  Redirect to page with auth data
              example :  return redirect()->intended('dashboard')->with('user_data', Auth::user()); */
   
    
            return response()->json([
                'user' => $user,
                'message' => 'User logged in via Github successfully!',
            ], 200);
        } catch (\Exception $e) {

            Log::error("Auth failed" . $e->getMessage());
            return response()->json([
                'error' => 'Github authentication failed.',
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
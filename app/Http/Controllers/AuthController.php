<?php

namespace App\Http\Controllers;
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
   public function showLoginForm(){
        return inertia('Login'); // Login view
    }


   public function formLogin(Request $request){
        try {

            // Trim email and password fields before validating
            $request->merge([
                'email' => trim($request->input('email')),
                'password' => trim($request->input('password')),
            ]);

            //Validate
            $credentials = $request->validate([
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:8',
                ]);

                Log::info('Incoming request data:', $request->all());


                $user = User::where('email', $credentials['email'])
                    ->where('provider', 'form')
                    ->first();


                    
                    // compare password 
                    if (!$user || !Hash::check($credentials['password'], $user->password)) {
                        return response()->json(['error' => 'The provided credentials do not match our records.',], 401);
                    }
                
                    // authenticate user
                    Auth::login($user,  true);

                    if(Auth::user()->isAdmin){
                        return response()->json([
                        'redirectUrl' => route('admin'),  
                    ], 200);
                    }


                    return response()->json([
                        'redirectUrl' => route('dashboard'),  
                    ], 200);

                 
                
               /*   //     Testing with postman/pest
                    //     Uncomment me to test this function
                    
                    return response()->json([
                        'user' => $user,
                        'message' => 'User logged in via Form successfully!',
                    ], 200); */
               

        } catch (\Exception $e) {
          
            return response()->json([
                'error' => 'Form authentication failed.',
                'details' => $e->getMessage(), // Include the exception message for debugging
            ], 500);
        }
    }


     public function googleLogin(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')->user();

            // Check if user exists
            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                ],
                [
                    'name' => $googleUser ->getName(),
                    'provider' => 'google'
                ]
            );      

             // authenticate user
            Auth::login($user, true);


            // Redirect to page with auth data
            return to_route('dashboard')->with('user_data', Auth::user());
   

              /*
                    Testing with postman/pest
                    Uncomment me to test this function
    
                    return response()->json([
                        'user' => $user,
                        'message' => 'User logged in via Google successfully!',
                    ], 200);

            */

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

            // Check if user exists
            $user = User::updateOrCreate(
                [
                    'email' => $githubUser->getEmail(),
                ],
                [
                    'name' => $githubUser ->getName(),
                    'provider' => 'github'
                ]
            );


           // authenticate user
            Auth::login($user, true);


            // Redirect to page with auth data
            return to_route('dashboard')->with('user_data', Auth::user());
   

             /*
                    Testing with postman/pest
                    Uncomment me to test this function
    
                    return response()->json([
                        'user' => $user,
                        'message' => 'User logged in via Github successfully!',
                    ], 200);

            */

        } catch (\Exception $e) {

            Log::error("Auth failed" . $e->getCode());
            return response()->json([
                'error' => 'Github authentication failed.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}
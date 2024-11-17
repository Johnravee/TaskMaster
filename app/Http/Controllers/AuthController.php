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
            //Validate
            $credentials = $request->validate([
                    'email' => 'required|string|email|max:255',
                    'password' => 'required|string|min:8',
                ]);


                $user = User::where('email', $credentials['email'])
                    ->where('provider', 'form') 
                    ->first();

                    // compare password 
                    if (!$user || !Hash::check($credentials['password'], $user->password)) {
                        return back()->withErrors([
                            'email' => 'The provided credentials do not match our records.',
                        ]);
                        
                    }
                
                // authenticate user
                Auth::login($user,  true);


                // Redirect to page with auth data
                // return to_route('dashboard')->with('user_data', Auth::user());

                 
                
                //     Testing with postman/pest
                //     Uncomment me to test this function
                    
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

            // Check if user exists
            $user = User::updateOrCreate(
                [
                    'email' => $googleUser->getEmail(),
                    'provider' => 'google',
                ],
                [
                    'name' => $googleUser ->getName(),
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
                    'provider' => 'github',
                ],
                [
                    'name' => $githubUser ->getName(),
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

            Log::error("Auth failed" . $e->getMessage());
            return response()->json([
                'error' => 'Github authentication failed.',
                'details' => $e->getMessage(),
            ], 500);
        }
    }

}

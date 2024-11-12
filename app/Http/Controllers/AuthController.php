<?php

namespace App\Http\Controllers;
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
   public function show(){
        // login view
    }


    public function authenticate(Request $request){

        //Validate input
         $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);


        $user = User::where('email', $credentials['email'])->first();
        


        //Verify provided email and password
            if (!$user || !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }
            
     
        Auth::login($user, $remember = true);
        
        
         /* redirect to dashboard
            -->return here<--- */
    }
}

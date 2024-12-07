<?php

namespace App\Http\Controllers;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log; 
use Illuminate\Support\Facades\Hash;  
use Illuminate\Auth\Events\PasswordReset;
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


    public function resetPassword(Request $request){

        Log::info('password email reset'. $request->input('email'));
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
        $request->only('email')
        );

        $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['email' => __($status)]);
 
      Log::info('Status of email reset'. $status);
      
       return $status;
    }


    public function updatePassword(Request $request){
        $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);
 
    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));
 
            $user->save();
 
            event(new PasswordReset($user));
        }
    );
 
    return $status === Password::PASSWORD_RESET
                ?  response()->json(['redirectURL' => '/login'], 200)
                : back()->withErrors(['email' => [__($status)]]);
    }


}
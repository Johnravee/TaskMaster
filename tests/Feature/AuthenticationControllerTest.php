<?php   

use App\Models\User;



test('asserting to authenticate user using login form', function () {


    // retrieve user data from database
    $user = User::where('email', 'sally_1731636325@gmail.com')->first(); 

   

    // send request to form login route to authenticate provided credentials 
    $response = $this->postJson('/form/login', [
        'email' => 'sally_1731636325@gmail.com',
        'password' => '123456789',  
    ]);

    // Assert that the response status is 200 OK
    $response->assertStatus(200);

    // expected response ng database
    $response->assertJson([
        'user' => [
            'name' => $user->name,  
            'email' => $user->email,  
            'provider' => $user->provider,  
            'id' => (string) $user->id,  
        ],
        'message' => 'User logged in via Form successfully!'
    ]);


    $this->assertAuthenticatedAs($user);
});





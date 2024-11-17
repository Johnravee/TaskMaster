<?php


// user creation test
test('User is created', function () {
    $email = 'sally_' . time() . '@gmail.com'; // Generates a unique email
    
    // send request to users route to create user
    $response = $this->postJson('/users', [
        'name' => 'Sally',
        'email' => $email,
        'password' => '123456789',
        'provider' => 'form'
    ]);


    // expected response ng database
    $response
        ->assertStatus(201)
        ->assertExactJson([
            'message' => 'User created successfully!', 
            'user' => [
                'created_at' => $response->json('user.created_at'),
                'email' => $email, 
                'id' => $response->json('user.id'),
                'name' => 'Sally',
                'provider' => 'form',
                'updated_at' => $response->json('user.updated_at'),
            ]
        ]);
});




test("User is log out", function(){


    $response = $this->getJson('/logout');
    
    $this->assertGuest(); 

});
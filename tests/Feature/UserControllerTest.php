<?php

use App\Models\User;


// get all users (admin)
test("Get all users from database", function(){

    $response = $this->getJson('/admin/users');

    // Expected response 
    $response->assertStatus(200);
});


test('User is created', function () {
   
    $user = User::factory()->create();
    
    // Send a request to create another user
    $response = $this->postJson('/users', [
        'name' => $user->name,
        'email' => fake()->unique()->safeEmail(), 
        'password' => '123456789',
        'provider' => 'form',
        'isAdmin' => $user->isAdmin,
    ]);

    // Expected response 
    $response
        ->assertStatus(201)
        ->assertJson([
            'message' => 'User created successfully!',
            'user' => [            
                'id' => $response->json('user.id'),
                'name' => $user->name,
                'email' => $response->json('user.email'),
                'provider' => 'form',
                'isAdmin' => $user->isAdmin,
                
            ]
        ]);
});



// logout user
test("User is log out", function(){


    $response = $this->getJson('/logout');
    
    $this->assertGuest(); 

});




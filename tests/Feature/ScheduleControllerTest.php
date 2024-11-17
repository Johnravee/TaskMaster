<?php

use Carbon\Carbon;



/* 
    old code for fetching test data
    test('asserting an schedule of user by using user ID', function (){

        $sampleUserId = "6735f6c09605ec58f60a2872"; // replace with actual user ID in the 
        
        // send request to task route to create schedule
        $response = $this->getJson("/schedules/{$sampleUserId}");


        $response
                ->assertStatus(200);
                
    }); */


    
test('Schedule fetch on specific user', function () {
 
     $user = \App\Models\User::factory()->create(); // Create random user
    
    // Get the user ID
    $sampleUserId = $user->id; 

    // Send a GET request to the schedules endpoint using the sample user ID
    $response = $this->getJson("/schedules/{$sampleUserId}");


    $response->assertStatus(200);

    
});

// schedule creation test
test('Schedule is created', function () {
    $start = Carbon::now()->addDay()->toISOString();
    $end = Carbon::now()->addDays(2)->toISOString();
   
    $user = \App\Models\User::factory()->create(); // Create random user

    // Send request to task route to create schedule
    $response = $this->postJson('/tasks', [
        'title' => 'Sample Event',
        'description' => 'Sample description',
        'start' => $start,
        'end' => $end,
        'category' => 'Sample category',
        'status' => 'Sample status',
        'user_id' => $user->id, 
    ]);

    // Expected response from the database, asserting status and JSON structure
    $response
        ->assertStatus(201)
        ->assertJson([
            'title' => 'Sample Event',
            'description' => 'Sample description',
            'start' => $start,
            'end' => $end,
            'category' => 'Sample category',
            'status' => 'Sample status',
            'user_id' => (string) $user->id, // Ensure the ID is returned as a string
        ]);
});

    /* 
        
        schedule updating test

        --------> Code here <--------

    */


// schedule deleting test

test('Schedule is deleted', function () {
 
    $schedule = \App\Models\Schedule::factory()->create(); // create new schedule 

    $response = $this->deleteJson("/schedule/{$schedule->id}");

    // Expected response after deletion
    $response
        ->assertStatus(202)  
        ->assertExactJson([
            'status' => 1,  
        ]);

   
    $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
});




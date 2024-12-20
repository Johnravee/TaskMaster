<?php

use Carbon\Carbon;



// get all schedules (admin)
test("Get all schedules from database", function(){

    $response = $this->getJson('/admin/schedules');
    
    // Expected response 
    $response->assertStatus(200);
});


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

    // Expected response 
    $response
        ->assertStatus(201);
        
});

// schedule updating test
test('Schedule is updated', function () {
    // Create a user and a schedule
    $user = \App\Models\User::factory()->create();
    $schedule = \App\Models\Schedule::factory()->create([
        'user_id' => $user->id
    ]);
    
    $updatedStart = Carbon::now()->addDay()->toISOString();
    $updatedEnd = Carbon::now()->addDays(2)->toISOString();

    // Updated data
    $updateData = [
        '_id' => $schedule->id,
        'user_id' => $user->id,
        'title' => 'Updated Event',
        'description' => 'Updated description',
        'start' => $updatedStart,
        'end' => $updatedEnd,
        'category' => 'Updated category',
        'status' => 'Updated status'
    ];

    // Send PUT request to update the schedule
    $response = $this->putJson("/schedule", $updateData);

    // Expected response 
    $response
        ->assertStatus(200)
        ->assertJson([
            'message' => 'Schedule updated successfully',
            'data' => [
                'title' => 'Updated Event',
                'description' => 'Updated description',
                'start' => $updatedStart,
                'end' => $updatedEnd,
                'category' => 'Updated category',
                'status' => 'Updated status'
            ]
        ]);

    // Verify the database was updated
    $this->assertDatabaseHas('schedules', [
        '_id' => $schedule->id,
        'title' => 'Updated Event',
        'description' => 'Updated description',
        'category' => 'Updated category',
        'status' => 'Updated status'
    ]);
});


// schedule deleting test

test('Schedule is deleted', function () {
 
    $schedule = \App\Models\Schedule::factory()->create(); // create new schedule 

    $response = $this->deleteJson("/schedule/{$schedule->id}");

    // Expected response 
    $response
        ->assertStatus(202)  
        ->assertExactJson([
            'status' => 1,  
        ]);

   
    $this->assertDatabaseMissing('schedules', ['id' => $schedule->id]);
});



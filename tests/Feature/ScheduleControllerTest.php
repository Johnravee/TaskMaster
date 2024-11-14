<?php

use Carbon\Carbon;



    /* 

    schedule fetching test

        --------> Code here <--------

    */


// schedule creation test
test('asserting an exact json match for task creation', function () {
   
    $start = Carbon::now()->addDay()->toISOString();  
    $end = Carbon::now()->addDays(2)->toISOString();
    $userId = '6735f6c09605ec58f60a2872'; // Replace with actual user ID from users collection

    // send request to task route to create schedule
    $response = $this->postJson('/tasks', [
        'title' => 'Sample Event',
        'description' => 'Sample description',
        'start' => $start,
        'end' => $end,
        'category' => 'Sample category',
        'user_id' => $userId,
    ]);

    // expected response ng database
    $response
        ->assertStatus(201)
        ->assertJson([
        'title' => 'Sample Event',
        'description' => 'Sample description',
        'start' => $start,
        'end' => $end,
        'category' => 'Sample category',
        'user_id' => $userId,
        'created_at' => $response->json('created_at'), 
        'updated_at' => $response->json('updated_at'),
        'id' => $response->json('id'), 
    ]);
});

    /* 
        
        schedule updating test

        --------> Code here <--------

    */


// schedule deleting test
test('asserting an exact json match for task delete', function (){
    $scheduleId = "6735fbf4207318ab6d0f7a22"; //change with the value of schedule id in the database
    $userId = "6735f6c09605ec58f60a2872"; // change with the value of user_id in the database

    // send request to schedule route to delete schedule
    $response = $this->deleteJson('/schedule', [
        'id' => $scheduleId,
        'user_id' => $userId,
    ]);

    // expected response ng database
    $response
        ->assertStatus(202)
        ->assertExactJson([
            'status' => 1
        ]);



});



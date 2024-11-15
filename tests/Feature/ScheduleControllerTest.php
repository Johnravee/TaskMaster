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
    $scheduleId = "6736b28d560e7f210a0a6272"; //change with the value of schedule id in the database
  

    // send request to schedule route to delete schedule
     $response = $this->deleteJson("/schedule/{$scheduleId}");

    // expected response ng database
    $response
        ->assertStatus(202)
        ->assertExactJson([
            'status' => 1
        ]);



});



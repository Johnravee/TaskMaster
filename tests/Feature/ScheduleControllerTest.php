<?php

use Carbon\Carbon;



    test('asserting an schedule of user by using user ID', function (){

        $sampleUserId = "6735f6c09605ec58f60a2872"; // replace with actual user ID in the 
        
        // send request to task route to create schedule
        $response = $this->getJson("/schedules/{$sampleUserId}");


        $response
                ->assertStatus(200);
                
    })
;

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
        'status' => 'Sample status',
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
        'status' => 'Sample status',
        'user_id' => $userId,
        
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



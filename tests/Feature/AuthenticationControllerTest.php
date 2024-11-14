<?php


// Pending pa 


test('example', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
});

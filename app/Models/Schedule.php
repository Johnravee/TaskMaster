<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Schedule extends Eloquent
{
  protected $connection = 'mongodb';  
 protected $fillable = [
        'title', 'start', 'end', 'all_day',
    ];

    //Reserve lang 'to if oks na yung login
    // protected $fillable = [
    //     'title', 'start', 'end', 'all_day', 'user_id',
    // ];
}

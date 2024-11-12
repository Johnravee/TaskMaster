<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Schedule extends Eloquent
{
  protected $connection = 'mongodb';  

    protected $fillable = [
        'title', 'description','start', 'end', 'category' , 'user_id',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Schedule extends Eloquent
{

  use HasFactory;
  protected $connection = 'mongodb';  

    protected $fillable = [
        'title', 'description','start', 'end', 'category' , 'user_id', 'status'
    ];
}

<?php

namespace App\Models;
use MongoDB\Laravel\Eloquent\Model  as Eloquent;
use Illuminate\Database\Eloquent\Model;

class ScheduleModel extends Eloquent
{
 protected $connection = 'mongodb';  
 protected $fillable = [
        'title', 'start', 'end', 'all_day', 'user_id',
    ];

    protected $collection = 'schedules';
}
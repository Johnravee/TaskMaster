<?php

use App\Console\Commands\CheckMissedSchedules;
use App\Console\Commands\SendUpcomingScheduleNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;




// change task schedule for demo purposes onleee
// php artisan schedule:run
Schedule::command(SendUpcomingScheduleNotification::class)->everySixHours();
Schedule::command(CheckMissedSchedules::class)->everyFiveSeconds();



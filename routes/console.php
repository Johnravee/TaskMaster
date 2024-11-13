<?php

use App\Console\Commands\SendUpcomingScheduleNotification;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Schedule::command(SendUpcomingScheduleNotification::class)->everySixHours();

//Call the command 
Schedule::call(function () {
    logger('kupal only');
})->everySixHours();

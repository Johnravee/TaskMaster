<?php

namespace App\Console\Commands;

use App\Models\Schedule;
use App\Models\User;
use App\Notifications\UpcomingScheduleNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log; 




class SendUpcomingScheduleNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
      protected $signature = 'app:send-upcoming-schedule-notification';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send notifications for events happening tomorrow';

    /**
     * Execute the console command.
     */
   public function handle()
{
    try {
        //Get the current date +1 
        $tomorrow = now()->addDay()->toDateString();

        //Find Schedule for tomorrow
        $schedules = Schedule::where('start', $tomorrow)
                            ->get();

        if ($schedules->isEmpty()) {
            Log::info('No events scheduled for tomorrow.');
        } else {
            Log::info('Schedules for tomorrow: ' . $schedules->toJson());
        }

        // Loop through the schedules and send notifications
        foreach ($schedules as $schedule) {
            // Find the user associated with the schedule
        $user = User::where("_id", $schedule->user_id)->first();

            if ($user) {
                // Send notification to the user
                $user->notify(new UpcomingScheduleNotification($schedule));
            } 
        }
        } catch (\Exception $e) {
            Log::info('Sending upcoming schedule email to user failed'. $e->getMessage());
        }
}



}

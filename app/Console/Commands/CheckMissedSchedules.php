<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log; 
use App\Models\Schedule;
use Carbon\Carbon;
class CheckMissedSchedules extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-missed-schedules';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send and update missed schedules';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
           $currentDate = Carbon::now()->toDateTimeString();
            $missedSchedules = Schedule::where('end', '<=', $currentDate)
                                        ->update(['status' => 'Missed']);

            if ($missedSchedules === 0) {
                Log::info('No missed schedules.');
            } 
        } catch (\Exception $e) {
            Log::info('Check missed schedule error'. $e->getMessage());
        }
    }
}

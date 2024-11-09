<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function create(Request $request)
    {
        // Log the incoming request data (view in laravel.log)
        Log::info('Request data from schedule form:', $request->all());

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string',
            'all_day' => 'required|boolean',
        ]);

        // Log the validated data (view in laravel.log)
        Log::info('Validated data:', $validated);

        try {
            
            $schedule = Schedule::create($validated);

            // Log the created schedule (view in laravel.log)
            Log::info('Schedule created:', $schedule->toArray());

          
            return response()->json($schedule, 201);

        } catch (\Exception $e) {
            
            Log::error('Error creating schedule: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create schedule'], 500);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function show(Request $request){

            //For testing only (gawing auth user id if ok na yung front-end)
            $userId = $request->input("_id");
        try {
         
            //For testing only (gawing user_id pag oks na yung front-end)
            $schedules = Schedule::where('id', $userId)->get();

            return response()->json(['data' => $schedules], 200);

        } catch (\Exception $e) {

             Log::error('Error fetching schedules:'. $e->getMessage());
             return response()->json(['error' => 'Failed to get all schedule'], 500);
        }
    }

    
    public function store(Request $request)
    {
         // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string',
            'category' => 'required|string|max:255',
            'user_id' => 'regex:/^[a-f0-9]{24}$/' //mongodb id rule
        ]);

        Log::info('Task request',$request->all());


        try {
            $schedule = Schedule::create($validated);

            return response()->json($schedule, 201);

        } catch (\Exception $e) {
            
            Log::error('Error creating schedule: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create schedule'], 500);
        }
    }
    

    public function update(Request $request){
        //pending
    }


    public function destroy(Request $request){
        $objectId = $request->input('id');

        Log::info("Destroy id : $objectId");
    }
}

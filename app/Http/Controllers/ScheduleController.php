<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
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

    
    public function store(ScheduleStoreRequest $request)
    {
        try {

            // Validate input
            $validated = $request->validated();

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
        $userId = $request->input('user_id');


        Log::info("Destroy id : $objectId $userId");
    }
}

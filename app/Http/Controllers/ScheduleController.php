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
            $userId = $request->input("user_id");
        try {
         
            //For testing only (gawing user_id pag oks na yung front-end)
            // find all schedules for the user
            $schedules = Schedule::where('user_id', $userId)->get();

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

            // create new schedule
            $schedule = Schedule::create($validated);

            return response()->json($schedule, 201);

        } catch (\Exception $e) {
            
            Log::error('Error creating schedule: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create schedule'], 500);
        }
    }
    

    //pending
    public function update(Request $request){
        $scheduleId = $request->input("_id");
        $userId = $request->input("user_id");


        Log::info("update request : $scheduleId and $userId");
        return response()->json(["data" => "update request $scheduleId and $userId"], 200);
    }


    public function destroy(Request $request){
        try{
            $objectId = $request->input('id');
            $userId = $request->input('user_id');

            // delete schedule
            $result = Schedule::where('_id', $objectId) 
                                ->where('user_id', $userId)
                                ->delete();

            if(!$result){
                return response()->json(['error' => 'Failed to delete schedule'], 500);
            }

            return response()->json(["status" => $result], 202);

        }catch(\Exception $e){
            Log::error('Error deleting schedule:'. $e->getMessage());
            return response()->json(['error' => 'Failed to delete schedule'], 500);
        }

    }

 
    }
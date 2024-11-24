<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ScheduleController extends Controller
{

    // for admin only!
    public function index(){
        try{
            //Get 10 schedules per page
            $schedules = Schedule::paginate(10);

            if(!$schedules){
                return response()->json(['message' => 'No schedules found'], 404);
            }

            return response()->json($schedules, 200);

        }catch(\Exception $e){
            Log::error("All schedule not found : ". $e->getMessage());
            return response()->json(['message' => 'Error fetching all schedules'], 500);
        }
    }

    public function show(){
          
        try {
         
            if(!Auth::check()){
                return response()->json([], 403);
            }
            
            $authenticatedUserId = Auth::user()->_id;

            // find all schedules for the user
            $schedules = Schedule::where('user_id', $authenticatedUserId)->get();

            return response()->json( $schedules, 200);
            

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
            $validated['user_id'] = Auth::user()->_id;
            $validated['status'] = 'Pending';

            // create new schedule
            $schedule = Schedule::create($validated);

            return response()->json($schedule, 201);

        } catch (\Exception $e) {
            
            Log::error('Error creating schedule: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create schedule'], 500);
        }
    }
    

 // update schedule
    public function update(Request $request)
{
    try {
        $scheduleId = $request->input("_id");
        $user_id = $request->input('user_id');

        $updateData = $request->only(['title', 'description', 'start', 'end', 'category', 'status']);

        $scheduleUpdateResult = Schedule::where('_id', $scheduleId)
            ->where("user_id", $user_id)
            ->update($updateData);

        if (!$scheduleUpdateResult) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }

        return response()->json(["message" => "Schedule updated successfully", "data" => $updateData], 200);
    } catch (\Exception $e) {
        Log::error('Error updating schedule: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update schedule'], 500);
    }
}



    public function destroy($id){   
        try{
            $scheduleId = $id;
           

            // delete schedule
            $result = Schedule::where('_id', $scheduleId)   ->delete();

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
<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function show($id){
            $userId = $id;
        try {
         

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
    

 // update schedule
    public function update(Request $request)
    {
        try {

            $scheduleId = $request->input("_id");
            $title = $request->input('title');
            $description = $request->input('description');
            $start = $request->input('start');
            $end = $request->input('end');
            $category = $request->input('category');
            $status = $request->input('status');
            $user_id = $request->input('user_id'); 


            // Prepare the data for update
            $updateData = [
                'title' => $title,
                'description' => $description,
                'start' => $start,
                'end' => $end,
                'category' => $category,
                'status' => $status,
            ];

            // Update the schedule
            $scheduleUpdateResult = Schedule::where('_id', $scheduleId)
                                            ->where("user_id", $user_id)
                                            ->update($updateData);

            if(!$scheduleUpdateResult){
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
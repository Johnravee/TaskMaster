<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScheduleStoreRequest;
use Illuminate\Http\Request;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ScheduleController extends Controller
{

    public function show(){
          
        try {
         
            if(!Auth::check()){
                return response()->json([], 403);
            }
            
            $authenticatedUserId = Auth::user()->_id;

            // find all schedules for the user
            $schedules = Schedule::where('user_id', $authenticatedUserId)
            ->where('status', 'Pending')
            ->get();

            return response()->json( $schedules, 200);
            

        } catch (\Exception $e) {

             Log::error('Error fetching schedules:'. $e->getMessage());
             return response()->json(['error' => 'Failed to get all schedule'], 500);
        }
    }

    public function showHistory(){
        try {
         
            if(!Auth::check()){
                return response()->json([], 403);
            }
            
            $authenticatedUserId = Auth::user()->_id;
            $currentDate = Carbon::now()->toDateTimeString();


            // find all missed schedules for the user
            $schedules = Schedule::where('user_id', $authenticatedUserId)
                                ->where('end' , '<=', $currentDate)
                                ->where('status', 'Missed')
                                ->get();


            return response()->json( $schedules, 200);
            

        } catch (\Exception $e) {

             Log::error('Error fetching schedules History:'. $e->getMessage());
             return response()->json(['error' => 'Failed to get all schedule History'], 500);
        }
    }

    public function ShowDone(){
        try {
            $done = Schedule::where('status', 'Done')->get();
            
            if($done){
                return response()->json($done, 200);
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }


    public function clearHistory(){
try {
         
            if(!Auth::check()){
                return response()->json([], 403);
            }
            
            $authenticatedUserId = Auth::user()->_id;


            // clear all missed schedules for the user
            $schedules = Schedule::where('user_id', $authenticatedUserId) 
                                ->where('status', 'Missed')
                                ->delete();


            return response()->json([], 200);
            

        } catch (\Exception $e) {

             Log::error('Error clearing schedules History:'. $e->getMessage());
             return response()->json(['error' => 'Failed to clearing schedule History'], 500);
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
        $scheduleId = $request->input("scheduleID");
        $user_id = $request->input('userID');

        $updateData = $request->only(['title', 'description', 'end', 'category', 'status']);

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

// update task to done
    public function updateTaskToDone(Request $request){
        try {
            $scheduleId = $request->input("id");
            $update = Schedule::where("_id", $scheduleId)
                                ->update(['status' => 'Done']);

             if(!$update){
                return response()->json(['Can\'t update status to done'], 404);
             }

             return response()->json(['Success updated status to done'], 200);
                                
        }catch(\Exception $e ){
            Log::error('Error updating task to done'. $e->getMessage());
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


    public function counter(){
        try{
            $countUsers = User::count();
            $countMissed = Schedule::where('status', 'Missed')->count();
            $countPending = Schedule::where('status', 'Pending')->count();
            

            return response()->json([$countUsers, $countMissed, $countPending], 200);

        }catch(\Exception $e){
            Log::error('Unexpected error on counter : '. $e->getMessage());
        }
    }
 
    }
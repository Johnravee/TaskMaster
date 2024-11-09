<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\ScheduleModel;

class ScheduleController extends Controller
{
    public function create(Request $request){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|string|max:255',
            'end' => 'required|string|',
            'all_day' => 'required|boolean',
            'status' => 'required|string',
            'user_id' => 'required|exists:users,_id' // Validate user_id exists in the users collection
        ]);


         $schedule = ScheduleModel::create([
            'title' => $validated['title'],
            'start' => $validated['start'],
            'end' => $validated['end'],
            'all_day' => $validated['all_day'],
            'user_id' => $validated['user_id'], // Store the user_id in the event
        ]);

         return response()->json($schedule, 201);
    }
}
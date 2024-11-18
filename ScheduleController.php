public function update(Request $request)
{
    try {
        $updateData = $request->only(['title', 'description', 'start', 'end', 'category', 'status']);
        
        $updated = Schedule::where('_id', $request->input('_id'))
                          ->where('user_id', $request->input('user_id'))
                          ->update($updateData);

        if (!$updated) {
            return response()->json(['error' => 'Schedule not found'], 404);
        }

        return response()->json(['message' => 'Schedule updated successfully', 'data' => $updateData], 200);
        
    } catch (\Exception $e) {
        Log::error('Error updating schedule: ' . $e->getMessage());
        return response()->json(['error' => 'Failed to update schedule'], 500);
    }
}

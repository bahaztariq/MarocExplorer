<?php

namespace App\Http\Controllers;

use App\Models\activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    /**
     * Display a listing of all activities.
     */
    public function index()
    {
        $activities = activity::with('destination')->get();

        return response()->json([
            'message' => 'Activities fetched successfully.',
            'activities' => $activities,
        ], 200);
    }

    /**
     * Display a specific activity.
     */
    public function show($id)
    {
        $activity = activity::with('destination')->find($id);

        if (!$activity) {
            return response()->json([
                'message' => 'Activity not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Activity fetched successfully.',
            'activity' => $activity,
        ], 200);
    }

    /**
     * Search for activities by name.
     */
    public function search($query)
    {
        $activities = activity::where('name', 'like', "%$query%")
            ->with('destination')
            ->get();
        
        return response()->json([
            'message' => 'Search results fetched successfully.',
            'activities' => $activities,
        ], 200);
    }
}

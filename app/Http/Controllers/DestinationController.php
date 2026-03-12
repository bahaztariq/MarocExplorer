<?php

namespace App\Http\Controllers;

use App\Models\destination;
use Illuminate\Http\Request;

class DestinationController extends Controller
{
    /**
     * Display a listing of all destinations.
     */
    public function index()
    {
        $destinations = destination::with(['activities', 'dishes'])->get();

        return response()->json([
            'message' => 'Destinations fetched successfully.',
            'destinations' => $destinations,
        ], 200);
    }

    /**
     * Display a specific destination with its activities and dishes.
     */
    public function show($id)
    {
        $destination = destination::with(['activities', 'dishes'])->find($id);

        if (!$destination) {
            return response()->json([
                'message' => 'Destination not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Destination fetched successfully.',
            'destination' => $destination,
        ], 200);
    }


    /**
     * Search for destinations by name.
     */
    public function search($query)
    {
        $destinations = destination::where('name', 'like', "%$query%")
            ->with(['activities', 'dishes'])
            ->get();
        
        return response()->json([
            'message' => 'Search results fetched successfully.',
            'destinations' => $destinations,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\activity;
use App\Http\Requests\StoreactivityRequest;
use App\Http\Requests\UpdateactivityRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ActivityController extends Controller
{
    /**
     * Display a listing of all activities.
     */
    #[OA\Get(
        path: "/api/v1/activities",
        summary: "Display a listing of all activities",
        description: "Returns a list of all activities with their associated destination.",
        tags: ["Activities"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "Activities fetched successfully.")
        ]
    )]
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
    #[OA\Get(
        path: "/api/v1/activities/{id}",
        summary: "Display a specific activity",
        description: "Returns a specific activity with its associated destination.",
        tags: ["Activities"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the activity", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Activity fetched successfully."),
            new OA\Response(response: 404, description: "Activity not found.")
        ]
    )]
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
    #[OA\Get(
        path: "/api/v1/activities/search/{query}",
        summary: "Search activities",
        description: "Search for activities by name.",
        tags: ["Activities"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "query", in: "path", required: true, description: "The search query", schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Search results fetched successfully.")
        ]
    )]
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

    /**
     * Store a newly created activity.
     */
    #[OA\Post(
        path: "/api/v1/activities",
        summary: "Store a new activity",
        description: "Creates a new activity and returns it.",
        tags: ["Activities"],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["nom", "destination_id"],
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Hiking"),
                    new OA\Property(property: "destination_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Activity created successfully."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function store(StoreactivityRequest $request)
    {
        $activity = activity::create($request->validated());

        return response()->json([
            'message' => 'Activity created successfully.',
            'activity' => $activity,
        ], 201);
    }

    /**
     * Update the specified activity.
     */
    #[OA\Put(
        path: "/api/v1/activities/{id}",
        summary: "Update an existing activity",
        description: "Updates a specific activity and returns it.",
        tags: ["Activities"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the activity", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "nom", type: "string", example: "Hiking Updated"),
                    new OA\Property(property: "destination_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Activity updated successfully."),
            new OA\Response(response: 404, description: "Activity not found."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function update(UpdateactivityRequest $request, $id)
    {
        $activity = activity::find($id);

        if (!$activity) {
            return response()->json([
                'message' => 'Activity not found.',
            ], 404);
        }

        $activity->update($request->validated());

        return response()->json([
            'message' => 'Activity updated successfully.',
            'activity' => $activity,
        ], 200);
    }
}

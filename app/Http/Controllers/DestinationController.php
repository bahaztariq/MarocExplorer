<?php

namespace App\Http\Controllers;

use App\Models\destination;
use App\Http\Requests\StoredestinationRequest;
use App\Http\Requests\UpdatedestinationRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class DestinationController extends Controller
{
    /**
     * Display a listing of all destinations.
     */
    #[OA\Get(
        path: "/api/v1/destinations",
        summary: "Display a listing of all destinations",
        description: "Returns a list of all destinations with their associated activities and dishes.",
        tags: ["Destinations"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "Destinations fetched successfully.")
        ]
    )]
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
    #[OA\Get(
        path: "/api/v1/destinations/{id}",
        summary: "Display a specific destination",
        description: "Returns a specific destination with its associated activities and dishes.",
        tags: ["Destinations"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the destination", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Destination fetched successfully."),
            new OA\Response(response: 404, description: "Destination not found.")
        ]
    )]
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
    #[OA\Get(
        path: "/api/v1/destinations/search/{query}",
        summary: "Search destinations",
        description: "Search for destinations by name.",
        tags: ["Destinations"],
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
        $destinations = destination::where('name', 'like', "%$query%")
            ->with(['activities', 'dishes'])
            ->get();
        
        return response()->json([
            'message' => 'Search results fetched successfully.',
            'destinations' => $destinations,
        ], 200);
    }

    /**
     * Store a newly created destination.
     */
    #[OA\Post(
        path: "/api/v1/destinations",
        summary: "Store a new destination",
        description: "Creates a new destination and returns it.",
        tags: ["Destinations"],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description", "itineraire_id"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Chefchaouen"),
                    new OA\Property(property: "description", type: "string", example: "The Blue City"),
                    new OA\Property(property: "image", type: "string", nullable: true, example: "chefchaouen.jpg"),
                    new OA\Property(property: "itineraire_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Destination created successfully."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function store(StoredestinationRequest $request)
    {
        $destination = destination::create($request->validated());

        return response()->json([
            'message' => 'Destination created successfully.',
            'destination' => $destination,
        ], 201);
    }

    /**
     * Update the specified destination.
     */
    #[OA\Put(
        path: "/api/v1/destinations/{id}",
        summary: "Update an existing destination",
        description: "Updates a specific destination and returns it.",
        tags: ["Destinations"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the destination", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Chefchaouen Updated"),
                    new OA\Property(property: "description", type: "string", example: "The Blue City Updated"),
                    new OA\Property(property: "image", type: "string", nullable: true, example: "chefchaouen_new.jpg"),
                    new OA\Property(property: "itineraire_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Destination updated successfully."),
            new OA\Response(response: 404, description: "Destination not found."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function update(UpdatedestinationRequest $request, $id)
    {
        $destination = destination::find($id);

        if (!$destination) {
            return response()->json([
                'message' => 'Destination not found.',
            ], 404);
        }

        $destination->update($request->validated());

        return response()->json([
            'message' => 'Destination updated successfully.',
            'destination' => $destination,
        ], 200);
    }
}

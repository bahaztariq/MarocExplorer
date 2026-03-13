<?php

namespace App\Http\Controllers;

use App\Models\itineraire;
use App\Http\Requests\StoreitineraireRequest;
use App\Http\Requests\UpdateitineraireRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class ItineraireController extends Controller
{
    /**
     * Display a listing of all itineraires.
     */

    #[OA\Get(
        summary: "Display a listing of all itineraires",
        description: "Returns a list of all itineraires with their associated data.",
        path: "/api/v1/itineraires",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(
                response: 200,
                description: "Itineraires fetched successfully.",
            )
            ],
    )]
                
    public function index()
    {
        $itineraires = itineraire::with([
            'destination.activities',
            'destination.dishes',
        ])->get();

        return response()->json([
            'message' => 'Itineraires fetched successfully.',
            'itineraires' => $itineraires,
        ], 200);
    }

    /**
     * Store a newly created itineraire.
     */
    #[OA\Post(
        path: "/api/v1/itineraires",
        summary: "Store a newly created itineraire",
        description: "Creates a new itineraire and returns the created record.",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["title", "category", "duration", "image"],
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Exploring Marrakech"),
                    new OA\Property(property: "category", type: "string", example: "Cultural"),
                    new OA\Property(property: "duration", type: "string", example: "3 days"),
                    new OA\Property(property: "image", type: "string", example: "marrakech.jpg"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Itineraire created successfully."),
            new OA\Response(response: 401, description: "Unauthorized."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function store(StoreitineraireRequest $request)
    {
        $validatedData = $request->validated();

        $validatedData['user_id'] = $request->user()->id;

        $itineraire = itineraire::create($validatedData);

        return response()->json([
            'message'    => 'Itineraire created successfully.',
            'itineraire' => $itineraire,
        ], 201);
    }

    /**
     * Display a specific itineraire.
     */
    #[OA\Get(
        path: "/api/v1/itineraires/{id}",
        summary: "Display a specific itineraire",
        description: "Returns a specific itineraire with its associated data.",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the itineraire", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Itineraire fetched successfully."),
            new OA\Response(response: 404, description: "Itineraire not found.")
        ]
    )]
    public function show($id)
    {
        $itineraire = itineraire::with([
            'destination.activities',
            'destination.dishes',
        ])->find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        return response()->json([
            'message'    => 'Itineraire fetched successfully.',
            'itineraire' => $itineraire,
        ], 200);
    }

    /**
     * Update the specified itineraire.
     */
    #[OA\Put(
        path: "/api/v1/itineraires/{id}",
        summary: "Update the specified itineraire",
        description: "Updates a specific itineraire and returns the updated record.",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the itineraire", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "title", type: "string", example: "Updated Title"),
                    new OA\Property(property: "category", type: "string", example: "Updated Category"),
                    new OA\Property(property: "duration", type: "string", example: "4 days"),
                    new OA\Property(property: "image", type: "string", example: "updated.jpg"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Itineraire updated successfully."),
            new OA\Response(response: 403, description: "Unauthorized."),
            new OA\Response(response: 404, description: "Itineraire not found."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function update(UpdateitineraireRequest $request, $id)
    {
        $itineraire = itineraire::find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        if ($itineraire->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validatedData = $request->validated();

        $itineraire->update($validatedData);

        return response()->json([
            'message'    => 'Itineraire updated successfully.',
            'itineraire' => $itineraire,
        ], 200);
    }

    /**
     * Remove the specified itineraire.
     */
    #[OA\Delete(
        path: "/api/v1/itineraires/{id}",
        summary: "Remove the specified itineraire",
        description: "Deletes a specific itineraire.",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the itineraire", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Itineraire deleted successfully."),
            new OA\Response(response: 403, description: "Unauthorized."),
            new OA\Response(response: 404, description: "Itineraire not found.")
        ]
    )]
    public function destroy(Request $request, $id)
    {
        $itineraire = itineraire::find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        if ($itineraire->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $itineraire->delete();

        return response()->json([
            'message' => 'Itineraire deleted successfully.',
        ], 200);
    }

    /**
     * Search itineraires by title or category.
     */
    #[OA\Get(
        path: "/api/v1/itineraires/search/{query}",
        summary: "Search itineraires",
        description: "Search itineraires by title or category or duration.",
        tags: ["Itineraires"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "query", in: "path", required: true, description: "The search query", schema: new OA\Schema(type: "string"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Itineraires found.")
        ]
    )]
    public function search($query)
    {
        $itineraires = itineraire::where('title', 'like', "%$query%")
            ->orWhere('category', 'like', "%$query%")
            ->orwhere('duration', 'like', "%$query%")
            ->with([
                'destination.activities',
                'destination.dishes',
            ])->get();

        return response()->json([
            'message' => 'Itineraires found.',
            'itineraires' => $itineraires,
        ], 200);
    }
}

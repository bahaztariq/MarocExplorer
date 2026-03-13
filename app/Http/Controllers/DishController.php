<?php

namespace App\Http\Controllers;

use App\Models\dish;
use App\Http\Requests\StoredishRequest;
use App\Http\Requests\UpdatedishRequest;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class DishController extends Controller
{
    /**
     * Display a listing of all dishes.
     */
    #[OA\Get(
        path: "/api/v1/dishes",
        summary: "Display a listing of all dishes",
        description: "Returns a list of all dishes with their associated destination.",
        tags: ["Dishes"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "Dishes fetched successfully.")
        ]
    )]
    public function index()
    {
        $dishes = dish::with('destination')->get();

        return response()->json([
            'message' => 'Dishes fetched successfully.',
            'dishes' => $dishes,
        ], 200);
    }

    /**
     * Display a specific dish.
     */
    #[OA\Get(
        path: "/api/v1/dishes/{id}",
        summary: "Display a specific dish",
        description: "Returns a specific dish with its associated destination.",
        tags: ["Dishes"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the dish", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Dish fetched successfully."),
            new OA\Response(response: 404, description: "Dish not found.")
        ]
    )]
    public function show($id)
    {
        $dish = dish::with('destination')->find($id);

        if (!$dish) {
            return response()->json([
                'message' => 'Dish not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Dish fetched successfully.',
            'dish' => $dish,
        ], 200);
    }

    /**
     * Search for dishes by name.
     */
    #[OA\Get(
        path: "/api/v1/dishes/search/{query}",
        summary: "Search dishes",
        description: "Search for dishes by name.",
        tags: ["Dishes"],
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
        $dishes = dish::where('name', 'like', "%$query%")
            ->with('destination')
            ->get();
        return response()->json([
            'message' => 'Search results fetched successfully.',
            'dishes' => $dishes,
        ], 200);
    }

    /**
     * Store a newly created dish.
     */
    #[OA\Post(
        path: "/api/v1/dishes",
        summary: "Store a new dish",
        description: "Creates a new dish and returns it.",
        tags: ["Dishes"],
        security: [['sanctum' => []]],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "description", "destination_id"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Couscous"),
                    new OA\Property(property: "description", type: "string", example: "Traditional Moroccan dish"),
                    new OA\Property(property: "image", type: "string", nullable: true, example: "couscous.jpg"),
                    new OA\Property(property: "destination_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Dish created successfully."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function store(StoredishRequest $request)
    {
        $dish = dish::create($request->validated());

        return response()->json([
            'message' => 'Dish created successfully.',
            'dish' => $dish,
        ], 201);
    }

    /**
     * Update the specified dish.
     */
    #[OA\Put(
        path: "/api/v1/dishes/{id}",
        summary: "Update an existing dish",
        description: "Updates a specific dish and returns it.",
        tags: ["Dishes"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the dish", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "Couscous Updated"),
                    new OA\Property(property: "description", type: "string", example: "Traditional Moroccan dish Updated"),
                    new OA\Property(property: "image", type: "string", nullable: true, example: "couscous_new.jpg"),
                    new OA\Property(property: "destination_id", type: "integer", example: 1)
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Dish updated successfully."),
            new OA\Response(response: 404, description: "Dish not found."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function update(UpdatedishRequest $request, $id)
    {
        $dish = dish::find($id);

        if (!$dish) {
            return response()->json([
                'message' => 'Dish not found.',
            ], 404);
        }

        $dish->update($request->validated());

        return response()->json([
            'message' => 'Dish updated successfully.',
            'dish' => $dish,
        ], 200);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use OpenApi\Attributes as OA;

class UserController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
    #[OA\Get(
        path: "/api/v1/users",
        summary: "Display the authenticated user's profile",
        description: "Returns the authenticated user's data.",
        tags: ["Users"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "User fetched successfully.")
        ]
    )]
    public function show(Request $request)
    {
        return response()->json([
            'message' => 'User fetched successfully.',
            'user'    => $request->user(),
        ], 200);
    }

    /**
     * Update the authenticated user's profile.
     */
    #[OA\Put(
        path: "/api/v1/users/{id}",
        summary: "Update user profile",
        description: "Updates the profile of a specific user. Authenticated user must own the profile.",
        tags: ["Users"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the user", schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Doe"),
                    new OA\Property(property: "email", type: "string", example: "john@example.com"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "User updated successfully."),
            new OA\Response(response: 403, description: "Unauthorized."),
            new OA\Response(response: 404, description: "User not found.")
        ]
    )]
    public function update(UpdateUserRequest $request, $id)     
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validatedData = $request->validated();

        $user->update($validatedData);

        return response()->json([
            'message' => 'User updated successfully.',
            'user'    => $user,
        ], 200);
    }

    /**
     * Delete the authenticated user's account.
     */
    #[OA\Delete(
        path: "/api/v1/users/{id}",
        summary: "Delete user account",
        description: "Deletes a specific user account. Authenticated user must own the account.",
        tags: ["Users"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, description: "The ID of the user", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "User deleted successfully."),
            new OA\Response(response: 403, description: "Unauthorized."),
            new OA\Response(response: 404, description: "User not found.")
        ]
    )]
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found.',
            ], 404);
        }

        if ($request->user()->id !== $user->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $user->tokens()->delete();
        $user->delete();

        return response()->json([
            'message' => 'User deleted successfully.',
        ], 200);
    }
}
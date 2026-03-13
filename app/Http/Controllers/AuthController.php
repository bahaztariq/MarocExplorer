<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    
    #[OA\Post(
        path: "/api/v1/register",
        summary: "User Registration",
        description: "Registers a new user and returns an access token.",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["name", "email", "password", "password_confirmation"],
                properties: [
                    new OA\Property(property: "name", type: "string", example: "John Doe"),
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                    new OA\Property(property: "password_confirmation", type: "string", format: "password", example: "password123"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "User registered successfully."),
            new OA\Response(response: 422, description: "Validation error.")
        ]
    )]
    public function register(StoreUserRequest $request)
    {

        $validatedData = $request->validated();
        
        $user = User::create($validatedData);

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    #[OA\Post(
        path: "/api/v1/login",
        summary: "User Login",
        description: "Authenticates a user and returns an access token.",
        tags: ["Authentication"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                required: ["email", "password"],
                properties: [
                    new OA\Property(property: "email", type: "string", format: "email", example: "john@example.com"),
                    new OA\Property(property: "password", type: "string", format: "password", example: "password123"),
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Login successful."),
            new OA\Response(response: 401, description: "Invalid credentials.")
        ]
    )]
    public function login(Request $request)
    {

        $validatedData = $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]); 
        $user = User::where('email', $validatedData['email'])->first();

        if(!$user || !Hash::check($validatedData['password'], $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        };

        $token = $user->createToken('api-token')->plainTextToken;

        // Auth::login($user);
        
        return response()->json([
            'message' => 'Login successful.',
            'user' => $user,
            'token' => $token,
        ], 200);
    }

    /**
     * User Logout
     */
    #[OA\Post(
        path: "/api/v1/logout",
        summary: "User Logout",
        description: "Invalidates the user's access token.",
        tags: ["Authentication"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "Logout successful."),
            new OA\Response(response: 401, description: "No authenticated user found.")
        ]
    )]
    public function logout(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json([
                'message' => 'Logout successful.'
            ], 200);
        }

        return response()->json([
            'message' => 'No authenticated user found.'
        ], 401);
    }
}
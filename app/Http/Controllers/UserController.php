<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display the authenticated user's profile.
     */
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